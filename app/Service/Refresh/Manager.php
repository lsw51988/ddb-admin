<?php

/**
 * Created by PhpStorm.
 * User: 阿德
 * Date: 2018/10/29
 * Time: 21:35
 */
namespace Ddb\Service\Refresh;

use Ddb\Core\Service;
use Ddb\Modules\BikeRefresh;
use Ddb\Modules\Member;
use Ddb\Modules\MemberPoint;
use Ddb\Modules\NewBike;
use Ddb\Modules\SecondBike;

class Manager extends Service
{
    public function refresh($data, $needPoint)
    {
        $this->db->begin();
        $bikeRefresh = new BikeRefresh();

        if (!$bikeRefresh->save($data)) {
            $this->db->rollback();
            return false;
        }
        if ($needPoint) {
            $member = Member::findFirst($data['member_id']);
            if ($data['type'] == BikeRefresh::TYPE_NEW) {
                if (!service('point/manager')->create($member, MemberPoint::TYPE_REFRESH_NB, null, null, null, $data['bike_id'])) {
                    $this->db->rollback();
                    return false;
                }
                $newBike = NewBike::findFirst($data['bike_id']);
                if (!$newBike->setUpdatedAt(date('Y-m-d H:i:s'))->save()) {
                    $this->db->rollback();
                    return false;
                }
            } else {
                if (!service('point/manager')->create($member, MemberPoint::TYPE_REFRESH_SHB, $data['bike_id'])) {
                    $this->db->rollback();
                    return false;
                }
                $secondBike = SecondBike::findFirst($data['bike_id']);
                if (!$secondBike->setUpdatedAt(date('Y-m-d H:i:s'))->save()) {
                    $this->db->rollback();
                    return false;
                }
            }
        }
        $this->db->commit();
        return true;
    }
}