<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-4
 * Time: 下午9:34
 */

namespace Ddb\Service\Point;

use Ddb\Modules\Member;
use Ddb\Modules\MemberPoint;
use Ddb\Modules\Order;
use Ddb\Service\BaseService;

class Manager extends BaseService
{
    /**
     * @param Member $member
     * @param $type
     * @param null $second_bike_id
     * @param null $appeal_id
     * @return bool
     */
    public function create(Member $member, $type, $second_bike_id = null, $appeal_id = null, $lost_bike_id = null, $new_bike_id = null)
    {
        $memberPoint = new MemberPoint();
        $point = MemberPoint::$typeScore[$type];
        $memberPoint->setMemberId($member->getId())
            ->setType($type)
            ->setValue($point);
        if ($second_bike_id) {
            $memberPoint->setSecondBikeId($second_bike_id);
        }
        if ($appeal_id) {
            $memberPoint->setAppealId($appeal_id);
        }
        if ($lost_bike_id) {
            $memberPoint->setLostBikeId($lost_bike_id);
        }
        if ($new_bike_id) {
            $memberPoint->setNewBikeId($new_bike_id);
        }
        $this->db->begin();
        if (!$memberPoint->save()) {
            $this->db->rollback();
            return false;
        }
        $currentPoint = (int)$member->getPoints();
        $endPoint = $currentPoint + $point;
        if ($endPoint < 0) {
            return false;
        }
        if (!$member->setPoints($endPoint)->save()) {
            $this->db->rollback();
            return false;
        }
        $this->db->commit();
        return true;
    }

    public function recharge($member, $body, $ip, $totalFee)
    {
        $url = di("config")->pay->PAY_URL;
        $param = [];
        $param['appid'] = di("config")->app->APP_ID;
        $param['body'] = $body;
        $param['mch_id'] = di("config")->pay->MCH_ID;
        $param['nonce_str'] = md5(di("security")->hash($member->getId() . rand(100000, 99999) . time()));
        $param['notify_url'] = di("config")->pay->NOTIFY_URL;
        $param['openid'] = $member->getOpenId();
        $param['out_trade_no'] = $member->getId() . '_' . time() . rand(10000, 99999);//订单号
        $param['spbill_create_ip'] = $ip;
        $param['total_fee'] = $totalFee;//单位分钱
        $param['trade_type'] = "JSAPI";
        $sign = "";
        foreach ($param as $k => $v) {
            $sign = $sign . $k . "=" . $v . "&";
        }
        $sign = $sign . "key=" . di("config")->pay->PAY_KEY;
        $sign = strtoupper(md5($sign));
        $param['sign'] = $sign;

        $order = new Order();
        if (!$order->setMemberId($member->getId())->save($param)) {
            app_log("pay")->error("创建order订单失败");
            return false;
        }
        $xml = $this->arrayToXml($param);
        $result = curl_request($url, "POST", $xml);
        $rData = json_decode(json_encode(simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        if ($rData['return_code'] == "SUCCESS") {
            $order->setReturnCode($rData['return_code'])
                ->setReturnMsg($rData['return_msg'])
                ->setResultCode($rData['result_code']);
            if ($rData['result_code'] == "SUCCESS") {
                //准备给小程序的数据
                $prepay_id = $rData['prepay_id'];
                $order->setPrepayId($prepay_id)->save();
                $wechatData['nonceStr'] = md5(di("security")->hash($member->getId() . rand(10000, 99999) . time()));;
                $wechatData['package'] = "prepay_id=" . $prepay_id;
                $wechatData['signType'] = "MD5";
                $wechatData['timeStamp'] = time();
                $wechatSign = "appId=" . di("config")->app->APP_ID . "&";
                foreach ($wechatData as $k => $v) {
                    $wechatSign = $wechatSign . $k . "=" . $v . "&";
                }
                $wechatSign = $wechatSign . "key=" . di("config")->pay->PAY_KEY;
                $wechatSign = strtoupper(md5($wechatSign));
                $wechatData['paySign'] = $wechatSign;
                $wechatData['orderId'] = $order->getId();
                return $wechatData;
            } else {
                $order->setErrCode($rData['result_code'])
                    ->setErrCodeDes($rData['result_code_desc'])
                    ->save();
                app_log("pay")->error("支付失败,订单编号:" . $param['out_trade_no'] . ",result_code_desc:" . $rData['result_code_desc']);
                return false;
            }
        } else {
            $order->setReturnCode($rData['return_code']);
            app_log("pay")->error("支付失败,订单编号:" . $param['out_trade_no'] . ",return_msg:" . $rData['return_msg']);
            return false;
        }

    }

    private function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $xml .= "<" . $key . ">" . $this->arrayToXml($val) . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }
}