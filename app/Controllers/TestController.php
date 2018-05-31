<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-28
 * Time: 上午12:01
 */

namespace Ddb\Controllers;


use Ddb\Core\BaseController;
use Ddb\Models\MemberBikeImages;
use Ddb\Models\RepairImages;
use Ddb\Modules\SmsCode;
use Phalcon\Mvc\Controller;

class TestController extends BaseController
{
    /**
     * @Get("/test")
     */
    public function indexAction()
    {
        service("repair/query")->getByRadius(118.79809,32.04835);
    }

    /**
     * @Post("/near_mts")
     * 获取附近维修点的,根据半径进行筛选
     */
    public function near_mtsAction(){
        $data = $this->data;
        $longitude = $data['longitude'];
        $latitude = $data['latitude'];
        $nearMts = service("repair/query")->getNearMtsByRadius($longitude,$latitude);
        return $this->success($nearMts);
    }

    /**
     * @Get("/{repairId:[0-9]+}/images")
     * 根据维修点id获取他的照片
     */
    public function repairImgsAction($repairId){
        $images = RepairImages::find([
            "columns"=>"id",
            "conditions"=> "repair_id = ".$repairId
        ]);
        $data = [];
        foreach($images as $image){
            $data[] = di("config")->app->URL."/wechat/repair/repairImg/".$image['id'];
        }
        return $this->success($data);
    }

    /**
     * @Get("/smsCount")
     */
    public function smsAction(){
        $count = SmsCode::count("mobile=" . "15077893963" . " AND created_at>='" . Date("Y-m-d 00:00:00", time()) . "'");
        echo $count;
    }

    /**
     * @Get("/testConfig")
     */
    public function testConfigAction(){
        print_r($this->request->getClientAddress());
    }

    /**
     * @Get("/pay")
     */
    public function payAction(){
        $url = di("config")->pay->PAY_URL;
        $param = [];
        $param['appid'] = "wx3bd752036e968963";
        $param['body'] = "电动帮-积分充值";
        $param['mch_id'] = "1504528021";
        $param['nonce_str'] = md5(di("security")->hash('1'.rand(100000,99999).time()));
        $param['notify_url'] = "https://www.ebikea.com/wechat/point/pay_callback";
        $param['openid'] = "oKgHM4myAdesr0AyoIU_JXjvOVz8";
        $param['out_trade_no'] = "2018053107";
        $param['spbill_create_ip'] = "121.225.203.141";
        $param['total_fee'] = "8";//分钱
        $param['trade_type'] = "JSAPI";

        $sign = "";
        foreach ($param as $k=>$v){
            $sign = $sign.$k."=".$v."&";
        }
        $sign = $sign."key=fb9e16006856eacc2500856f1c39a05f";
        $sign = strtoupper(md5($sign));
        //$sign = $sign."&key="
        $param['sign'] = $sign;

        $xml = $this->arrayToXml($param);

        $result = curl_request($url, "POST", $xml);
        $rData = json_decode(json_encode(simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA)),true);
        if($rData['return_code']=="SUCCESS" && $rData['result_code']=="SUCCESS"){
            //准备给小程序的数据
            $prepay_id = $rData['prepay_id'];
            //$wechatData['appId'] = "wx3bd752036e968963";

            $wechatData['nonceStr'] = $param['nonce_str'];
            $wechatData['package'] = "prepay_id=".$prepay_id;
            $wechatData['signType'] = "MD5";
            $wechatData['timeStamp'] = time();
            $wechatSign = "appId=wx3bd752036e968963&";
            foreach ($wechatData as $k=>$v){
                $wechatSign = $wechatSign.$k."=".$v."&";
            }
            $wechatSign = $wechatSign."key=fb9e16006856eacc2500856f1c39a05f";
            $wechatSign = strtoupper(md5($wechatSign));
            $wechatData['paySign'] = $wechatSign;
            return $this->success($wechatData);
        }else{
            //告诉小程序出错的具体信息

        }
    }

    private function arrayToXml($arr){
        $xml = "<xml>";
        foreach ($arr as $key=>$val){
            if(is_array($val)){
                $xml.="<".$key.">".$this->arrayToXml($val)."</".$key.">";
            }else{
                $xml.="<".$key.">".$val."</".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }
}