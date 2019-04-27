<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-6-12
 * Time: 下午9:43
 */

namespace Ddb\Service\Lost;


use Ddb\Core\Service;
use Ddb\Models\LostBikeContacts;
use Ddb\Models\LostBikes;
use Ddb\Modules\BikeRefresh;
use Ddb\Modules\LostBike;
use Ddb\Modules\Member;
use Ddb\Modules\MemberPoint;

class Manager extends Service
{
    public function contact($member, $id)
    {
        $lostBikeBrowse = LostBikeContacts::findFirst([
            "conditions" => "lost_bike_id = $id AND member_id = " . $member->getId(),
            "order" => "created_at DESC"
        ]);
        $lostBikeBrowse->setCallTime(date("Y-m-d H:i:s", time()))
            ->save();
    }

    public function browse($member, $id)
    {
        $lostBikeBrowse = new LostBikeContacts();
        $lostBikeBrowse->setMemberId($member->getId())
            ->setLostBikeId($id)
            ->save();
    }

    public function auth(LostBike $lostBike, $request)
    {
        if ($request['type'] == 'pass') {
            $status = LostBike::STATUS_PASS;
            $message = '丢失车辆审核通过';
        } else {
            $status = LostBike::STATUS_REFUSE;
            $lostBike->setReason($request['reason']);
            $message = '丢失车辆审核拒绝，原因：' . $request['reason'];
        }
        $this->db->begin();
        if (!$lostBike->setStatus($status)->save()) {
            $this->db->rollback();
            return false;
        }
        if ($status == LostBike::STATUS_REFUSE) {
            //取消扣除积分
            $member = Member::findFirst($lostBike->getMemberId());
            if (!service('point/manager')->create($member, MemberPoint::TYPE_PUBLISH_LB_REFUSE, null, null, $request['bike_id'], null)) {
                $this->db->rollback();
                return false;
            }
        }
        if (!service('member/manager')->saveMessage($member->getId(), $message)) {
            $this->db->rollback();
            return false;
        }
        $this->db->commit();
        return true;
    }

    /**
     * @param LostBike $lostBike
     * @return bool
     */
    public function refresh(LostBike $lostBike)
    {
        $todayRefreshCount = BikeRefresh::count('bike_id = ' . $lostBike->getId() . ' AND type = ' . BikeRefresh::TYPE_LOST . ' AND created_at>=\'' . date('Y-m-d 00:00:00') . '\'');
        $this->db->begin();
        $lostBike->setUpdatedAt(date('Y-m-d H:i:s'));
        if (!$lostBike->save()) {
            $this->db->rollback();
            return false;
        }
        $bikeRefreshModel = new BikeRefresh();
        $bikeRefreshData = [
            'bike_id' => $lostBike->getId(),
            'type' => BikeRefresh::TYPE_LOST,
            'member_id' => $lostBike->getMemberId(),
            'created_at' => date('Y-m-d H:i:s')
        ];
        if (!$bikeRefreshModel->save($bikeRefreshData)) {
            $this->db->rollback();
            return false;
        }
        if ($todayRefreshCount >= 3) {
            $member = Member::findFirst($lostBike->getMemberId());
            if (!service('point/manager')->create($member, MemberPoint::TYPE_REFRESH_LB, null, null, $lostBike->getId())) {
                $this->db->rollback();
                return false;
            }
        }
        $this->db->commit();
        return true;
    }

    public function revoke(LostBike $lostBike, $data)
    {
        $lostBike->setStatus($data['status'])
            ->setUpdatedAt(date('Y-m-d H:i:s'));
        //已经找到
        if ($data['status'] == LostBike::STATUS_FOUND) {
            $lostBike->setFinishTime(date('Y-m-d H:i:s'));
        }
        //放弃寻找
        if ($data['status'] == LostBike::STATUS_NOT_FIND) {
            $lostBike->setFailTime(date('Y-m-d H:i:s'));
        }
        if ($lostBike->save()) {
            return true;
        }
        return false;
    }
}