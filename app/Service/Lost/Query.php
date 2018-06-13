<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-6-12
 * Time: 下午8:56
 */

namespace Ddb\Service\Lost;


use Ddb\Core\Service;
use Ddb\Models\LostBikes;
use Ddb\Models\MemberBikeImages;
use Ddb\Modules\Member;
use Ddb\Modules\MemberBike;

class Query extends Service
{
    public function getList($search = []){
        $columns = "id,rewards,city,district,created_at";
        $conditions = "1=1";
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
        if (!empty($search['rewards'])) {
            switch ($search['rewards']) {
                case 1:
                    $order = "rewards ACS";
                    break;
                case 2:
                    $order = "rewards DESC";
                    break;
            }
        }

        $data = LostBikes::page($columns, $conditions, [], $order,$search['current_page']);
        return $data;
    }

    public function getDetail($id)
    {
        $lostBike = LostBikes::findFirst($id);
        $memberBike = MemberBike::findFirstByMemberId($lostBike->getMemberId());
        $member = Member::findFirst($memberBike->getMemberId());

        $images = MemberBikeImages::find([
            "conditions" => "member_bike_id = ".$lostBike->getMemberBikeId(),
            "columns" => "id"
        ]);

        $imgUrls = [];
        foreach ($images as $shbImage) {
            $imgUrls[] = di("config")->app->URL . "/wechat/member/bikeImg/" . $shbImage->id;
        }

        $data = [];
        $data['voltage'] = $memberBike->getVoltage();
        $data['brand_name'] = $memberBike->getBrandName();
        $data['number'] = $memberBike->getNumber();
        $data['lost_date'] = date("Y-m-d",strtotime($lostBike->getCreatedAt()));
        $data['city'] = $lostBike->getCity();
        $data['district'] = $lostBike->getDistrict();
        $data['address'] = $lostBike->getAddress();
        $data['memo'] = $lostBike->getMemo();
        $data['rewards'] = $lostBike->getRewards();
        $data['mobile'] = $member->getMobile();
        $data['imgUrls'] = $imgUrls;

        return $data;
    }

}