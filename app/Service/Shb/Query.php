<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-16
 * Time: 下午11:47
 */

namespace Ddb\Service\Shb;


use Ddb\Core\Service;
use Ddb\Models\SecondBikeImages;
use Ddb\Modules\Member;
use Ddb\Modules\MemberPoint;
use Ddb\Models\Areas;
use Ddb\Modules\SecondBike;

class Query extends Service
{
    public function hasEnoughPoint($member)
    {
        if ($member->getPoints() < abs(MemberPoint::$typeScore[MemberPoint::TYPE_PUBLISH_SHB])) {
            return false;
        }
        return true;
    }

    public function getList($search = [])
    {
        $columns = "id,brand_name,out_price,city,district,created_at";
        $conditions = "status=1";
        if (!empty($search['time'])) {
            switch ($search['time']) {
                case 1:
                    $conditions = $conditions . " AND created_at>='" . date("Y-m-d 00:00:00") . "' AND created_at<='" . date("Y-m-d 23:59:59") . "'";
                    break;
                case 2:
                    $conditions = $conditions . " AND created_at>='" . date("Y-m-d 00:00:00", strtotime("-7 day")) . "' AND created_at<='" . date("Y-m-d 23:59:59") . "'";
                    break;
                case 3:
                    $conditions = $conditions . " AND created_at>='" . date("Y-m-d 00:00:00", strtotime("-1 month")) . "' AND created_at<='" . date("Y-m-d 23:59:59") . "'";
                    break;
            }
        }

        if (!empty($search['district'])) {
            $conditions = $conditions . " AND city='" . $search['city'] . "' AND district='" . $search['district'] . "'";
        }
        $order = "";
        if (!empty($search['price'])) {
            switch ($search['price']) {
                case 1:
                    $order = "out_price ACS";
                    break;
                case 2:
                    $order = "out_price DESC";
                    break;
            }
        }
        if (!empty($search['self_flag'])) {
            $conditions = $conditions . " AND member_id = " . $search['member_id'];
        }

        $data = SecondBike::page($columns, $conditions, [], $order);
        return $data;
    }

    public function getShbDetail($id)
    {
        $shb = SecondBike::findFirst($id);
        $seller = Member::findFirst($shb->getMemberId());

        $shbImages = SecondBikeImages::find([
            "conditions" => "second_bike_id = $id",
            "columns" => "id"
        ]);

        $imgUrls = [];
        foreach ($shbImages as $shbImage) {
            $imgUrls[] = di("config")->app->URL . "/wechat/member/bikeImg/" . $shbImage->id;
        }

        $data = [];
        $data['buy_date'] = substr($shb->getBuyDate(), 0, -3);
        $data['voltage'] = $shb->getVoltage();
        $data['brand_name'] = $shb->getBrandName();
        $data['out_price'] = $shb->getOutPrice();
        $data['city'] = $shb->getCity();
        $data['district'] = $shb->getDistrict();
        $data['detail_addr'] = $shb->getDetailAddr();
        $data['number'] = $shb->getNumber();
        $data['remark'] = $shb->getRemark();
        $data['created_at'] = $shb->getCreatedAt();
        $data['member_name'] = $seller->getRealName();
        $data['mobile'] = $seller->getMobile();
        $data['imgUrls'] = $imgUrls;

        return $data;
    }

    public function getManageDetail($id){
        $shb = SecondBike::findFirst($id);
        $seller = Member::findFirst($shb->getMemberId());

        $shbImages = SecondBikeImages::find([
            "conditions" => "second_bike_id = $id",
            "columns" => "id"
        ]);
        $imgUrls = [];
        foreach ($shbImages as $shbImage) {
            $imgUrls[] = di("config")->app->URL . "/wechat/member/bikeImg/" . $shbImage->id;
        }

        $data = [];
        $data['member_name'] = $seller->getRealName();
        $data['mobile'] = $seller->getMobile();
        $data['imgUrls'] = $imgUrls;
        $data['buy_date'] = substr($shb->getBuyDate(), 0, -3);
        $data['voltage'] = $shb->getVoltage();
        $data['brand_name'] = $shb->getBrandName();
        $data['out_price'] = $shb->getOutPrice();
        $data['in_status'] = $shb->getInStatus();
        $data['last_change_time'] = $shb->getLastChangeTime();
        $data['province'] = $shb->getProvince();
        $data['city'] = $shb->getCity();
        $data['district'] = $shb->getDistrict();
        $data['detail_addr'] = $shb->getDetailAddr();
        $data['number'] = $shb->getNumber();
        $data['remark'] = $shb->getRemark();

        return $data;
    }
}