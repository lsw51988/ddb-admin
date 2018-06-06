<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-16
 * Time: 下午11:19
 */

namespace Ddb\Service\Shb;


use Ddb\Core\Service;
use Ddb\Models\SecondBikes;
use Ddb\Models\SecondBikeBrowses;
use Ddb\Modules\Member;
use Ddb\Modules\MemberBike;
use Ddb\Modules\MemberPoint;

class Manager extends Service
{
    public function create($member, $data)
    {
        $addr = explode(",", $data['addr']);
        $data['province'] = $addr[0];
        $data['city'] = $addr[1];
        $data['district'] = $addr[2];
        $data['voltage'] = MemberBike::$voltageDesc[$data['voltage']];
        $this->db->begin();
        $shb = new SecondBikes();
        $data['buy_date'] = $data['buy_date'] . "-01 00:00:00";
        $shb->setMemberId($member->getId())
            ->setBuyDate($data['buy_date'])
            ->setVoltage($data['voltage'])
            ->setBrandName($data['brand_name'])
            ->setInPrice($data['in_price'])
            ->setOutPrice($data['out_price'])
            ->setProvince($data['province'])
            ->setCity($data['city'])
            ->setDistrict($data['district'])
            ->setDetailAddr($data['detail_addr'])
            ->setNumber($data['number']);
        if (isset($data['remark'])) {
            $shb->setRemark($data['remark']);
        }
        if (isset($data['last_change_time']) && $data['last_change_time']!="未更换") {
            $shb->setLastChangeTime($data['last_change_time']);
        }
        if (!$shb->save()) {
            $this->db->rollback();
            return false;
        }
        //扣除积分
        $currentMember = Member::findFirst($member->getId());
        if (service("point/manager")->create($currentMember, MemberPoint::TYPE_PUBLISH_SHB, $shb->getId())) {
            $this->db->commit();
            return $shb->getId();
        } else {
            return false;
        }
    }

    public function browse($member, $id)
    {
        $secondBikeBrowse = new SecondBikeBrowses();
        $secondBikeBrowse->setMemberId($member->getId())
            ->setSecondBikeId($id)
            ->save();
    }

    public function contact($member, $id)
    {
        $secondBikeBrowse = SecondBikeBrowses::findFirst([
            "conditions" => "second_bike_id = $id AND member_id = " . $member->getId(),
            "order" => "created_at DESC"
        ]);
        $secondBikeBrowse->setCallTime(date("Y-m-d H:i:s", time()))
            ->save();
    }
}