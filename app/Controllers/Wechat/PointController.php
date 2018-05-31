<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-16
 * Time: 下午5:21
 */

namespace Ddb\Controllers\Wechat;


use Ddb\Controllers\WechatAuthController;

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
     */
    public function payAction(){
        $member = $this->currentMember;
        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        $param = [];
        $param['appid'] = "wx3bd752036e968963";
        $param['body'] = "电动帮-积分充值";
        $param['mch_id'] = "1504528021";
        $param['nonce_str'] = md5(di("security")->hash($member->getId().rand(100000,99999).time()));
        $param['notify_url'] = "https://www.ebikea.com/wechat/point/pay_callback";
        $param['openid'] = "oKgHM4myAdesr0AyoIU_JXjvOVz8";
        $param['out_trade_no'] = "2018053101";
        $param['spbill_create_ip'] = "121.225.203.141";
        $param['total_fee'] = "8";//分钱
        $param['trade_type'] = "JSAPI";

        $sign = "";
        foreach ($param as $k=>$v){
            $sign = $sign.$k."=".$v."&";
        }
        $sign = substr($sign,0,(strlen($sign)-1));
        $param['sign'] = $sign;

        $result = curl_request($url, "POST", $param);
        print_r($result);
    }

    /**
     * @Get("/pay_callback")
     */
    public function payCallbackAction(){
        $data = $this->data;
        app_log("pay")->info($data);
    }

}