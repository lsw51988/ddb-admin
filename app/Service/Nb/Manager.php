<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-16
 * Time: 下午11:19
 */

namespace Ddb\Service\Nb;


use Ddb\Core\Service;
use Ddb\Models\Areas;
use Ddb\Models\NewBikeBrowses;
use Ddb\Models\NewBikes;
use Ddb\Models\SecondBikes;
use Ddb\Models\SecondBikeBrowses;
use Ddb\Modules\Member;
use Ddb\Modules\MemberBike;
use Ddb\Modules\MemberPoint;
use Ddb\Modules\Repair;
use Ddb\Modules\SecondBike;

class Manager extends Service
{
    /**
     * @param $member
     * @param $data
     * @param $repair '维修点数据
     * @return bool
     * 新车添加逻辑：
     * 1.判断该用户是否是店主，不是则先去添加自己的店铺，是则继续
     * 2.判断用户是否有足够积分
     * 3.
     */
    public function create(Member $member, Repair $repair, $data, $points)
    {
        $this->db->begin();
        $nb = new NewBikes();
        if (!$area = Areas::findFirstByDistrictCode($repair->getDistrict())) {
            return false;
        }
        switch ($data['voltage']) {
            case 1:
                $voltage = 48;
                break;
            case 2:
                $voltage = 60;
                break;
            case 3:
                $voltage = 72;
                break;
            case 4:
                $voltage = 96;
                break;
            case 5:
                $voltage = 'other';
                break;
        }

        //1.新车记录添加
        $nb->setMemberId($member->getId())
            ->setVoltage($voltage)
            ->setBrandName($data['brand_name'])
            ->setPrice($data['price'])
            ->setBatteryBrand($data['battery_brand'])
            ->setDistance($data['distance'])
            ->setGuaranteePeriod($data['guarantee_period'])
            ->setProvinceCode($repair->getProvince())
            ->setCityCode($repair->getCity())
            ->setDistrictCode($repair->getDistrict())
            ->setProvince($area->getProvinceName())
            ->setCity($area->getCityName())
            ->setDistrict($area->getDistrictName())
            ->setDetailAddr($repair->getAddress())
            ->setRemark($data['remark']);
        switch ($data['show_days_index']) {
            case 1:
                $nb->setAvailTime(date("Y-m-d H:i:s", strtotime("+7 day")));
                break;
            case 2:
                $nb->setAvailTime(date("Y-m-d H:i:s", strtotime("+14 day")));
                break;
            case 3:
                $nb->setAvailTime(date("Y-m-d H:i:s", strtotime("+30 day")));
                break;
            case 4:
                $nb->setAvailTime(date("Y-m-d H:i:s", strtotime("+90 day")));
                break;
            case 5:
                $nb->setAvailTime(date("Y-m-d H:i:s", strtotime("+180 day")));
                break;
        }
        if (isset($data['remark'])) {
            $nb->setRemark($data['remark']);
        }
        if (!$nb->save()) {
            $this->db->rollback();
            return false;
        }
        //2.积分扣除 发布新车的积分
        if (!service('point/manager')->create($member, MemberPoint::TYPE_PUBLISH_NB, null, null, null, $nb->getId())) {
            $this->db->rollback();
            return false;
        }

        //3.积分扣除 新车展示的积分
        $memberPoint = new MemberPoint();
        $point = MemberPoint::$typeScore[MemberPoint::TYPE_PUBLISH_NB];
        $showPoints = $points + $point;
        $memberPoint->setMemberId($member->getId())
            ->setType(MemberPoint::TYPE_SHOW_NB)
            ->setValue($showPoints);
        if (!$memberPoint->save()) {
            $this->db->rollback();
            return false;
        }

        $this->db->commit();
        return $nb->getId();
    }

    public function update($member, $data, $needPoints = 0)
    {
        $addr = explode(",", $data['addr']);
        $data['province'] = $addr[0];
        $data['city'] = $addr[1];
        $data['district'] = $addr[2];
        $data['voltage'] = MemberBike::$voltageDesc[$data['voltage']];
        $this->db->begin();
        if (!$nb = NewBikes::findFirst($data['id'])) {
            return false;
        }
        $nb->setMemberId($member->getId())
            ->setVoltage($data['voltage'])
            ->setBrandName($data['brand_name'])
            ->setPrice($data['price'])
            ->setProvince($data['province'])
            ->setCity($data['city'])
            ->setDistrict($data['district'])
            ->setDetailAddr($data['detail_addr'])
            ->setGuaranteePeriod($data['guarantee_period'])
            ->setBatteryBrand($data['battery_brand'])
            ->setDistance($data['distance']);
        if (isset($data['remark'])) {
            $nb->setRemark($data['remark']);
        }

        //如果有增加积分的操作
        if ($needPoints > 0) {
            if ($member->setPoints($member->getPoints() - $needPoints)->save()) {
                $this->db->rollback();
                return false;
            }
        }

        $nb->setAvailTime(date("Y-m-d H:i:s", strtotime($nb->getAvailTime()) + $data['add_days'] * 3600 * 24));

        if (!$nb->save()) {
            $this->db->rollback();
            return false;
        } else {
            $this->db->commit();
            return $nb->getId();
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
        $newBikeBrowse = NewBikeBrowses::findFirst([
            "conditions" => "new_bike_id = $id AND member_id = " . $member->getId(),
            "order" => "created_at DESC"
        ]);
        $newBikeBrowse->setCallTime(date("Y-m-d H:i:s", time()))
            ->save();
    }
}