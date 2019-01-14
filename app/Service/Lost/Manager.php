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

    public function auth(LostBike $lostBike,$request){
        if ($request['type'] == 'pass') {
            $status = LostBike::STATUS_PASS;
        } else {
            $status = LostBike::STATUS_REFUSE;
            $lostBike->setReason($request['reason']);
        }
        $this->db->begin();
        if (!$lostBike->setStatus($status)->save()) {
            $this->db->rollback();
            return false;
        }
        if($status == LostBike::STATUS_REFUSE){
            //取消扣除积分
            $member = Member::findFirst($lostBike->getMemberId());
            if (!service('point/manager')->create($member, MemberPoint::TYPE_PUBLISH_LB_REFUSE, null, null, $request['bike_id'], null)) {
                $this->db->rollback();
                return false;
            }
        }
        $this->db->commit();
        return true;
    }
}