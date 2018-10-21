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
    public function create($member, $data, $points)
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
            $provinceCode = $area->getProvinceCode();
            $cityCode = $area->getCityCode();
            $districtCode = $area->getDistrictCode();
        } else {
            $provinceCode = $data['province'];
            $cityCode = $data['city'];
            $districtCode = $data['district'];
            app_log()->info("获取地址信息失败：省==" . $data['province'] . " 市==" . $data['city'] . " 区==" . $data['district']);
        }
        $shb->setMemberId($member->getId())
            ->setBuyDate($data['buy_date'])
            ->setVoltage($data['voltage'])
            ->setBrandName($data['brand_name'])
            ->setInPrice($data['in_price'])
            ->setOutPrice($data['out_price'])
            ->setProvince($data['province'])
            ->setCity($data['city'])
            ->setDistrict($data['district'])
            ->setProvinceCode($provinceCode)
            ->setCityCode($cityCode)
            ->setDistrictCode($districtCode)
            ->setDetailAddr($data['detail_addr'])
            ->setNumber($data['number']);
        if (isset($data['remark'])) {
            $shb->setRemark($data['remark']);
        }
        if (isset($data['last_change_time']) && $data['last_change_time'] != "未更换") {
            $shb->setLastChangeTime($data['last_change_time']);
        }

        //2.积分扣除 发布二手车的积分
        if (!service('point/manager')->create($member, MemberPoint::TYPE_PUBLISH_SHB, $shb->getId())) {
            $this->db->rollback();
            return false;
        }
        //3.积分扣除 二手车展示天数
        $memberPoint = new MemberPoint();
        $point = MemberPoint::$typeScore[MemberPoint::TYPE_PUBLISH_SHB];
        $showPoints = $points + $point;
        $memberPoint->setMemberId($member->getId())
            ->setType(MemberPoint::TYPE_SHOW_SHB)
            ->setValue($showPoints);
        if (!$memberPoint->save()) {
            $this->db->rollback();
            return false;
        }

        if (!$shb->save()) {
            $this->db->rollback();
            return false;
        }
        $this->db->commit();
        return $shb->getId();
    }

    public function update($member, $data, $needPoints = 0)
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

        //如果有增加积分的操作
        if ($needPoints > 0) {
            if (!$member->setPoints($member->getPoints() - $needPoints)->save()) {
                $this->db->rollback();
                return false;
            }
        }

        $shb->setAvailTime(date("Y-m-d H:i:s", strtotime($shb->getAvailTime()) + $data['add_days'] * 3600 * 24));

        if (!$shb->save()) {
            $this->db->rollback();
            return false;
        } else {
            $this->db->commit();
            return $shb->getId();
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