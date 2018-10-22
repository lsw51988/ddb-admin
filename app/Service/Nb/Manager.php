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
use Ddb\Models\SecondBikeBrowses;
use Ddb\Modules\Member;
use Ddb\Modules\MemberBike;
use Ddb\Modules\MemberPoint;
use Ddb\Modules\NewBike;
use Ddb\Modules\Repair;

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
        if ($area = Areas::findFirst("province_code='" . $repair->getProvince() . "' AND city_code='" . $repair->getCity() . "' AND district_code='" . $repair->getDistrict() . "'")) {
            $province = $area->getProvinceName();
            $city = $area->getCityName();
            $district = $area->getDistrictName();
        } else {
            $province = $repair->getProvince();
            $city = $repair->getCity();
            $district = $repair->getDistrict();
            app_log()->info("创建新车时，获取地址信息失败: 区district_code=" . $repair->getDistrict());
        }
        //1.新车记录添加
        $nb->setMemberId($member->getId())
            ->setVoltage(MemberBike::$voltageDesc[$data['voltage']])
            ->setBrandName($data['brand_name'])
            ->setPrice($data['price'])
            ->setBatteryBrand($data['battery_brand'])
            ->setDistance($data['distance'])
            ->setGuaranteePeriod($data['guarantee_period'])
            ->setProvinceCode($repair->getProvince())
            ->setCityCode($repair->getCity())
            ->setDistrictCode($repair->getDistrict())
            ->setProvince($province)
            ->setCity($city)
            ->setDistrict($district)
            ->setDetailAddr($repair->getAddress())
            ->setRemark($data['remark']);
        $showDays = MemberPoint::getShowDays($data['show_days_index']);
        $nb->setAvailTime(date("Y-m-d H:i:s", strtotime("+$showDays day")));
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
        if (service('member/query')->isPrivilege($member)) {
            $point = MemberPoint::$typeScore[MemberPoint::TYPE_PUBLISH_NB] * 0.8;
        }

        $showPoints = $points - $point;
        $memberPoint->setMemberId($member->getId())
            ->setNewBikeId($nb->getId())
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
        if ($area = Areas::findFirst("province_name='" . $data['province'] . "' AND city_name='" . $data['city'] . "' AND district_name='" . $data['district'] . "'")) {
            $nb->setProvinceCode($area->getProvinceCode())
                ->setCityCode($area->getCityCode())
                ->setDistrictCode($area->getDistrictCode());
        } else {
            $nb->setProvinceCode($data['province'])
                ->setCityCode($data['city'])
                ->setDistrictCode($data['district']);
            app_log()->info("更新新车时，获取地址信息失败：省==" . $data['province'] . " 市==" . $data['city'] . " 区==" . $data['district']);
        }
        if (isset($data['remark'])) {
            $nb->setRemark($data['remark']);
        }

        //如果有增加积分的操作
        if ($needPoints > 0) {
            if (!$member->setPoints($member->getPoints() - $needPoints)->save()) {
                $this->db->rollback();
                return false;
            }
            //3.积分扣除 新车展示的积分
            $memberPoint = new MemberPoint();
            $memberPoint->setMemberId($member->getId())
                ->setType(MemberPoint::TYPE_SHOW_NB)
                ->setNewBikeId($nb->getId())
                ->setValue($needPoints);
            if (!$memberPoint->save()) {
                $this->db->rollback();
                return false;
            }
        }

        $showDays = MemberPoint::getShowDays($data['show_days_index']);
        $nb->setAvailTime(date("Y-m-d H:i:s", strtotime($nb->getAvailTime()) + $showDays * 3600 * 24));

        if (!$nb->save()) {
            $this->db->rollback();
            return false;
        }

        $this->db->commit();
        return $nb->getId();
    }

    public function repub($member, $data, $needPoints)
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
            ->setStatus(NewBike::STATUS_CREATE);
        if (isset($data['remark'])) {
            $nb->setRemark($data['remark']);
        }

        //如果有增加积分的操作
        if ($needPoints > 0) {
            if (!$member->setPoints($member->getPoints() - $needPoints)->save()) {
                $this->db->rollback();
                return false;
            }
            //3.积分扣除 新车展示的积分
            $memberPoint = new MemberPoint();
            $memberPoint->setMemberId($member->getId())
                ->setType(MemberPoint::TYPE_SHOW_NB)
                ->setNewBikeId($nb->getId())
                ->setValue($needPoints);
            if (!$memberPoint->save()) {
                $this->db->rollback();
                return false;
            }
        }

        if (!$nb->save()) {
            $this->db->rollback();
            return false;
        }

        $this->db->commit();
        return $nb->getId();
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

    public function returnPoints($member, $nb)
    {
        $this->db->begin();
        //2.积分取消扣除 发布新车的积分
        if (!service('point/manager')->create($member, MemberPoint::TYPE_PUBLISH_NB_REFUSE, null, null, null, $nb->getId())) {
            $this->db->rollback();
            return false;
        }
        //3.积分取消扣除 新车展示天数
        $memberPoint = MemberPoint::findFirst('member_id = ' . $member->getId() . ' AND type = ' . MemberPoint::TYPE_SHOW_NB . ' AND new_bike_id = ' . $nb->getId() . ' order by id DESC');
        $showPoints = $memberPoint->getValue();
        $memberPointModel = new MemberPoint();
        $memberPointModel->setMemberId($member->getId())
            ->setType(MemberPoint::TYPE_SHOW_NB_REFUSE)
            ->setValue($showPoints);
        if (!$memberPointModel->save()) {
            $this->db->rollback();
            return false;
        }
        if (!$member->setPoints($member->getPoints() + $showPoints)->save()) {
            $this->db->rollback();
            return false;
        }
        $this->db->commit();
        return true;
    }
}