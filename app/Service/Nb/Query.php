<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-16
 * Time: 下午11:47
 */

namespace Ddb\Service\Nb;


use Ddb\Core\Service;
use Ddb\Models\Areas;
use Ddb\Models\NewBikeImgs;
use Ddb\Models\NewBikes;
use Ddb\Models\SecondBikeImages;
use Ddb\Modules\Member;
use Ddb\Modules\MemberPoint;
use Ddb\Modules\SecondBike;
use Phalcon\Paginator\Adapter\QueryBuilder;

class Query extends Service
{
    public function hasEnoughPoint(Member $member, $dayIndex)
    {
        $point = abs(MemberPoint::$typeScore[MemberPoint::TYPE_PUBLISH_NB]);
        switch ($dayIndex) {
            case 1:
                $days = 7;
                break;
            case 2:
                $days = 14;
                break;
            case 3:
                $days = 30;
                break;
            case 4:
                $days = 90;
                break;
            case 5:
                $days = 180;
                break;
        }
        //新车展示天数所需积分
        if ($member->getPrivilege() == Member::IS_PRIVILEGE && strtotime($member->getPrivilegeTime()) > time()) {
            $showDaysPoints = $days * 10 * 0.8;
        } else {
            $showDaysPoints = $days * 10;
        }
        $point = $point + $showDaysPoints;

        if ($member->getPoints() < $point) {
            return false;
        }
        return $point;
    }

    public function getList($search = [])
    {
        $columns = "id,brand_name,price,city,district,detail_addr,status,avail_time,voltage";
        $conditions = "1=1";

        if (!empty($search['district'])) {
            $conditions = $conditions . " AND city='" . $search['city'] . "' AND district='" . $search['district'] . "'";
        }

        $order = "";
        if (!empty($search['price'])) {
            switch ($search['price']) {
                case 1:
                    $conditions = $conditions . " AND price>=1000 AND price <=2000";
                    break;
                case 2:
                    $conditions = $conditions . " AND price>=2000 AND price <=3000";
                    break;
                case 3:
                    $conditions = $conditions . " AND price>=3000 AND price <=4000";
                    break;
                case 4:
                    $conditions = $conditions . " AND price>=4000 AND price <=5000";
                    break;
                case 5:
                    $conditions = $conditions . " AND price>=5000";
                    break;
            }
        }

        if (!empty($search['self_flag'])) {
            $conditions = $conditions . " AND member_id = " . $search['member_id'];
        }else{
            $conditions = $conditions ." AND avail_time >= '" . date("Y-m-d H:i:s",time()) . "'";
        }

        $data = NewBikes::page($columns, $conditions, [], $order);
        return $data;
    }

    public function getAdminList($search = [])
    {
        $columns = "S.id,S.brand_name,S.out_price,S.province,S.city,S.district,S.created_at,S.status,M.real_name,M.mobile";
        $builder = $this->modelsManager->createBuilder()
            ->columns($columns)
            ->from(["S" => SecondBike::class])
            ->leftJoin(Member::class, "S.member_id = M.id", 'M')
            ->leftJoin(Areas::class, "A.district_code = S.district_code", "A");
        if (!empty($search['status'])) {
            $builder->andWhere('S.status=' . $search['status']);
        }
        if (!empty($search['real_name'])) {
            $builder->andWhere('M.real_name LIKE %' . $search['real_name'] . '%');
        }
        if (!empty($search['province'])) {
            $builder->andWhere('S.province_code = ' . $search['province']);
        }
        if (!empty($search['city'])) {
            $builder->andWhere('S.city_code = ' . $search['city']);
        }
        if (!empty($search['district'])) {
            $builder->andWhere('S.district_code = ' . $search['district']);
        }
        $paginator = new QueryBuilder([
            'builder' => $builder,
            'limit' => $search['limit'],
            'page' => $search['page']
        ]);
        $data = $paginator->getPaginate();
        return $data;
    }

    public function getNbDetail($id)
    {
        $nb = NewBikes::findFirst($id);
        $seller = Member::findFirst($nb->getMemberId());

        $nbImages = NewBikeImgs::find([
            "conditions" => "new_bike_id = $id",
            "columns" => "id"
        ]);

        $imgUrls = [];
        foreach ($nbImages as $nbImage) {
            $imgUrls[] = di("config")->app->URL . "/wechat/nb/bikeImg/" . $nbImage->id;
        }

        $data = [];
        $data['voltage'] = $nb->getVoltage();
        $data['brand_name'] = $nb->getBrandName();
        $data['price'] = $nb->getPrice();
        $data['city'] = $nb->getCity();
        $data['district'] = $nb->getDistrict();
        $data['detail_addr'] = $nb->getDetailAddr();
        $data['remark'] = $nb->getRemark();
        $data['created_at'] = $nb->getCreatedAt();
        $data['member_name'] = $seller->getRealName();
        $data['mobile'] = $seller->getMobile();
        $data['imgUrls'] = $imgUrls;

        return $data;
    }

    public function getManageDetail($id)
    {
        $shb = SecondBike::findFirst($id);
        $seller = Member::findFirst($shb->getMemberId());

        $shbImages = SecondBikeImages::find([
            "conditions" => "second_bike_id = $id",
            "columns" => "id"
        ]);
        $imgUrls = [];
        foreach ($shbImages as $shbImage) {
            $imgUrls[] = di("config")->app->URL . "/wechat/shb/bikeImg/" . $shbImage->id;
        }

        $data = [];
        $data['member_name'] = $seller->getRealName();
        $data['mobile'] = $seller->getMobile();
        $data['imgUrls'] = $imgUrls;
        $data['buy_date'] = substr($shb->getBuyDate(), 0, -3);
        $data['voltage'] = $shb->getVoltage();
        $data['brand_name'] = $shb->getBrandName();
        $data['out_price'] = $shb->getOutPrice();
        $data['in_price'] = $shb->getInPrice();
        $data['in_status'] = $shb->getInStatus();
        $data['last_change_time'] = $shb->getLastChangeTime();
        $data['province'] = $shb->getProvince();
        $data['city'] = $shb->getCity();
        $data['district'] = $shb->getDistrict();
        $data['detail_addr'] = $shb->getDetailAddr();
        $data['number'] = $shb->getNumber();
        $data['remark'] = $shb->getRemark();
        $data['status'] = $shb->getStatus();

        return $data;
    }

    public function getDealCount($memberId)
    {
        $count = 0;
        $count = SecondBike::count(["member_id = $memberId"]);
        return $count;
    }
}