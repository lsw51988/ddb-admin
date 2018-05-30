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
}