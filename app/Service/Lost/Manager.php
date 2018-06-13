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
}