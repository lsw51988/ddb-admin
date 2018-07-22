<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-16
 * Time: 下午11:19
 */

namespace Ddb\Service\Shb;


use Ddb\Core\Service;
use Ddb\Models\Areas;
use Ddb\Models\SecondBikes;
use Ddb\Models\SecondBikeBrowses;
use Ddb\Modules\Member;
use Ddb\Modules\MemberBike;
use Ddb\Modules\MemberPoint;
use Ddb\Modules\SecondBike;

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
        if ($area = Areas::findFirst("province_name='" . $data['province'] . "' AND city_name='" . $data['city'] . "' AND district_name='" . $data['district'] . "'")) {
            $province = $area->getProvinceCode();
            $city = $area->getCityCode();
            $district = $area->getDistrictCode();
        } else {
            $province = $data['province'];
            $city = $data['city'];
            $district = $data['district'];
            app_log()->info("获取地址信息失败：省==" . $data['province'] . " 市==" . $data['city'] . " 区==" . $data['district']);
        }
        $shb->setMemberId($member->getId())
            ->setBuyDate($data['buy_date'])
            ->setVoltage($data['voltage'])
            ->setBrandName($data['brand_name'])
            ->setInPrice($data['in_price'])
            ->setOutPrice($data['out_price'])
            ->setProvince($province)
            ->setCity($city)
            ->setDistrict($district)
            ->setDetailAddr($data['detail_addr'])
            ->setNumber($data['number']);
        if (isset($data['remark'])) {
            $shb->setRemark($data['remark']);
        }
        if (isset($data['last_change_time']) && $data['last_change_time'] != "未更换") {
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

    public function update($member, $data)
    {
        $addr = explode(",", $data['addr']);
        $data['province'] = $addr[0];
        $data['city'] = $addr[1];
        $data['district'] = $addr[2];
        $data['voltage'] = MemberBike::$voltageDesc[$data['voltage']];
        $this->db->begin();
        if (!$shb = SecondBikes::findFirst($data['id'])) {
            return false;
        }
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
        if (isset($data['last_change_time']) && $data['last_change_time'] != "未更换") {
            $shb->setLastChangeTime($data['last_change_time']);
        }
        if (!$shb->save()) {
            $this->db->rollback();
            return false;
        }
        //扣除积分
        $currentMember = Member::findFirst($member->getId());
        if (service("point/manager")->create($currentMember, MemberPoint::TYPE_UPDATE_SHB, $shb->getId())) {
            $this->db->commit();
            return $shb->getId();
        } else {
            return false;
        }
    }

    public function repub($member, $data)
    {
        $addr = explode(",", $data['addr']);
        $data['province'] = $addr[0];
        $data['city'] = $addr[1];
        $data['district'] = $addr[2];
        $data['voltage'] = MemberBike::$voltageDesc[$data['voltage']];
        $this->db->begin();
        if (!$shb = SecondBikes::findFirst($data['id'])) {
            return false;
        }
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
            ->setNumber($data['number'])
            ->setStatus(SecondBike::STATUS_CREATE);
        if (isset($data['remark'])) {
            $shb->setRemark($data['remark']);
        }
        if (isset($data['last_change_time']) && $data['last_change_time'] != "未更换") {
            $shb->setLastChangeTime($data['last_change_time']);
        }
        if (!$shb->save()) {
            $this->db->rollback();
            return false;
        }
        //扣除积分
        $currentMember = Member::findFirst($member->getId());
        if (service("point/manager")->create($currentMember, MemberPoint::TYPE_REPUB_SHB, $shb->getId())) {
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