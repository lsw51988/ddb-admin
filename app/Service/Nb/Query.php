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
use Ddb\Modules\Member;
use Ddb\Modules\MemberPoint;
use Ddb\Modules\NewBike;
use Ddb\Modules\SecondBike;
use Phalcon\Paginator\Adapter\QueryBuilder;

class Query extends Service
{
    public function hasEnoughPoint(Member $member)
    {
        $point = MemberPoint::$typeScore[MemberPoint::TYPE_PUBLISH_NB];

        if ($member->getPoints() < abs($point)) {
            return false;
        }
        return $point;
    }

    public function getList($search = [])
    {
        $columns = "id,brand_name,price,city,district,detail_addr,status,voltage";

        if (!empty($search['self_flag'])) {
            $conditions = "member_id = " . $search['member_id'];
        } else {
            $conditions = "status=" . NewBike::STATUS_AUTH;
        }

        if (!empty($search['district']) && !empty($search['city'])) {
            $conditions = $conditions . " AND city_code='" . $search['city'] . "' AND district_code='" . $search['district'] . "'";
        } else {
            $conditions = $conditions . " AND city_code='" . $search['city'] . "'";
        }

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

        $order = "updated_at DESC";
        $data = NewBikes::page($columns, $conditions, [], $order);
        return $data;
    }

    public function getAdminList($search = [])
    {
        $columns = "S.id,S.brand_name,S.price,S.province,S.city,S.district,S.created_at,S.status,M.real_name,M.mobile";
        $builder = $this->modelsManager->createBuilder()
            ->columns($columns)
            ->from(["S" => NewBike::class])
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
        $nb = NewBike::findFirst($id);
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
        $data['member_name'] = $seller->getRealName();
        $data['mobile'] = $seller->getMobile();
        $data['imgUrls'] = $imgUrls;
        $data['voltage'] = $nb->getVoltage();
        $data['battery_brand'] = $nb->getBatteryBrand();
        $data['distance'] = $nb->getDistance();
        $data['guarantee_period'] = $nb->getGuaranteePeriod();
        $data['brand_name'] = $nb->getBrandName();
        $data['price'] = $nb->getPrice();
        $data['province'] = $nb->getProvince();
        $data['city'] = $nb->getCity();
        $data['district'] = $nb->getDistrict();
        $data['detail_addr'] = $nb->getDetailAddr();
        $data['remark'] = $nb->getRemark();
        $data['status'] = $nb->getStatus();

        return $data;
    }
}