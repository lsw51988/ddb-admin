<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-16
 * Time: 下午5:21
 */

namespace Ddb\Controllers\Wechat;


use Ddb\Controllers\WechatAuthController;
use Ddb\Modules\Member;
use Ddb\Modules\MemberPoint;
use Ddb\Modules\Order;
use Ddb\Modules\SmsCode;

/**
 * Class PointController
 * 用户积分CUR操作
 * @RoutePrefix("/wechat/point")
 */
class PointController extends WechatAuthController
{
    /**
     * @Get("/{member_id:[0-9]+}")
     */
    public function showAction($memberId){

    }


    /**
     * @Post("/")
     */
    public function createAction(){

    }

    /**
     * @Put("/{member_id:[0-9]+}")
     */
    public function editAction($memberId){

    }

    /**
     * @Post("/pay")
     * 充值积分
     */
    public function payAction(){
        $data = $this->data;
        $totalFee = $data['total_fee'];
        $requestIp = $this->request->getClientAddress();
        $member = $this->currentMember;
        if($wechatData = service("point/manager")->recharge($member,"电动帮-积分充值",$requestIp,$totalFee)){
            return $this->success($wechatData);
        }else{
            return $this->error();
        }
    }

    /**
     * @Post("/pay_callback")
     * 小程序回调
     */
    public function payCallbackAction(){
        $data = $this->data;
        $memberId= $this->currentMember->getId();
        $orderId = $data['orderId'];
        if($order = Order::findFirst($orderId)){
            $amount = $order->getTotalFee()/100;
            $type = "TYPE_RECHARGE_".$amount;
            $this->db->begin();
            $sData = [
                "member_id"=>$memberId,
                "point"=>$order->getTotalFee()/10
            ];
            $member = Member::findFirst($memberId);
            if(!$order->setFinishTime(Date("Y-m-d H:i:s",time()))->save()){
                $this->db->rollback();
                $smsCode = service("sms/manager")->create($member, SmsCode::TEMPLATE_RECHARGE_FAIL,SmsCode::TEMPLATE_RECHARGE_FAIL);
                di("queue")->useTube("SmsCode")->put(serialize(['smsCodeId' => $smsCode->getId(), null,$sData]));
                //短信通知管理员
            }

            if(!service("point/manager")->create($member, MemberPoint::$type)){
                $this->db->rollback();
                $smsCode = service("sms/manager")->create($member, SmsCode::TEMPLATE_RECHARGE_FAIL,SmsCode::TEMPLATE_RECHARGE_FAIL);
                di("queue")->useTube("SmsCode")->put(serialize(['smsCodeId' => $smsCode->getId(), null,$sData]));
                //短信通知管理员
            }
            if(!$member->setPoints($member->getPoints()+$order->getTotalFee()/10)->save()){
                $this->db->rollback();
                $smsCode = service("sms/manager")->create($member, SmsCode::TEMPLATE_RECHARGE_FAIL,SmsCode::TEMPLATE_RECHARGE_FAIL);
                di("queue")->useTube("SmsCode")->put(serialize(['smsCodeId' => $smsCode->getId(), null,$sData]));
                //短信通知管理员
            }
            $this->db->commit();
            return $this->success();
        }else{
            //此处应该记录该member_id
            app_log("pay")->error("member_id:".$this->currentMember->getId()."非法调用充值积分接口!");
            return $this->error("没有该订单");
        }
    }

}