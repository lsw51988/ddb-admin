<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-6-12
 * Time: 下午8:56
 */

namespace Ddb\Service\Lost;


use Ddb\Core\Service;
use Ddb\Models\Areas;
use Ddb\Models\LostBikes;
use Ddb\Models\MemberBikeImages;
use Ddb\Modules\LostBike;
use Ddb\Modules\Member;
use Ddb\Modules\MemberBike;
use Phalcon\Paginator\Adapter\QueryBuilder;

class Query extends Service
{
    public function getList($search = [])
    {
        $columns = "id,rewards,city,district,created_at";
        $conditions = "status=" . LostBike::STATUS_PASS;
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

        if (!empty($search['city']) && !empty($search['district'])) {
            $conditions = $conditions . " AND city='" . $search['city'] . "' AND district='" . $search['district'] . "'";
        } else {
            $conditions = $conditions . " AND city='" . $search['city'] . "'";
        }
        $order = "";
        if (!empty($search['rewards'])) {
            switch ($search['rewards']) {
                case 1:
                    $order = "rewards ASC";
                    break;
                case 2:
                    $order = "rewards DESC";
                    break;
            }
        }

        $data = LostBikes::page($columns, $conditions, [], $order, $search['page']);
        return $data;
    }

    public function getDetail($id)
    {
        $lostBike = LostBikes::findFirst($id);
        $memberBike = MemberBike::findFirstByMemberId($lostBike->getMemberId());
        $member = Member::findFirst($memberBike->getMemberId());

        $images = MemberBikeImages::find([
            "conditions" => "member_bike_id = " . $lostBike->getMemberBikeId(),
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
        $data['lost_date'] = date("Y-m-d", strtotime($lostBike->getCreatedAt()));
        $data['city'] = $lostBike->getCity();
        $data['district'] = $lostBike->getDistrict();
        $data['address'] = $lostBike->getAddress();
        $data['memo'] = $lostBike->getMemo();
        $data['rewards'] = $lostBike->getRewards();
        $data['mobile'] = $member->getMobile();
        $data['imgUrls'] = $imgUrls;

        return $data;
    }

    public function getAdminList($search)
    {
        $columns = "LB.id,LB.member_bike_id,LB.lost_date,LB.address,LB.memo,LB.rewards,LB.contact_time,LB.finish_time,LB.fail_time,LB.status,LB.reason,LB.created_at,M.real_name,M.mobile,A.province_name,A.city_name,A.district_name";
        $builder = $this->modelsManager->createBuilder()
            ->columns($columns)
            ->from(["LB" => LostBike::class])
            ->leftJoin(Member::class, "LB.member_id = M.id", 'M')
            ->leftJoin(Areas::class, "A.district_code = LB.district", "A");
        if (ok($search, 'status')) {
            $builder->andWhere('LB.status=' . $search['status']);
        }
        if (!empty($search['real_name'])) {
            $builder->andWhere('M.real_name LIKE %' . $search['real_name'] . '%');
        }
        if (!empty($search['province'])) {
            $builder->andWhere('LB.province = ' . $search['province']);
        }
        if (!empty($search['city'])) {
            $builder->andWhere('LB.city = ' . $search['city']);
        }
        if (!empty($search['district'])) {
            $builder->andWhere('LB.district = ' . $search['district']);
        }
        $paginator = new QueryBuilder([
            'builder' => $builder,
            'limit' => $search['limit'],
            'page' => $search['page']
        ]);
        $data = $paginator->getPaginate();
        return $data;
    }
}