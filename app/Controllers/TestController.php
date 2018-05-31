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
        print_r(di("config"));
    }

    /**
     * @Get("/pay")
     */
    public function strAction(){
        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        $param = [];
        $param['appid'] = "wx3bd752036e968963";
        $param['body'] = "电动帮-积分充值";
        $param['mch_id'] = "1504528021";
        $param['nonce_str'] = md5(di("security")->hash('1'.rand(100000,99999).time()));
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
}