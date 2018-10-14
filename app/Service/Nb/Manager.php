<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-16
 * Time: 下午11:19
 */

namespace Ddb\Service\Nb;


use Ddb\Core\Service;
use Ddb\Models\NewBikes;
use Ddb\Models\SecondBikes;
use Ddb\Models\SecondBikeBrowses;
use Ddb\Modules\Member;
use Ddb\Modules\MemberBike;
use Ddb\Modules\MemberPoint;
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
    public function create($member, $repair, $data, $points)
    {
        $data['province_code'] = $member['province'];
        $data['city_code'] = $member['city'];
        $data['district_code'] = $member['district'];
        $this->db->begin();
        $nb = new NewBikes();

        //1.新车记录添加
        $nb->setMemberId($member->getId())
            ->setVoltage($data['voltage'])
            ->setBrandName($data['brand_name'])
            ->setPrice($data['price'])
            ->setBatteryBrand($data['battery_brand'])
            ->setDistance($data['distance'])
            ->setGuaranteePeriod($data['guarantee_period'])
            ->setProvinceCode($data['province'])
            ->setCityCode($data['city'])
            ->setDistrictCode($data['district'])
            ->setProvince($repair['province'])
            ->setCity($repair['city'])
            ->setDistrict($repair['district'])
            ->setDetailAddr($data['address'])
            ->setRemark($data['remark']);
        switch ($data['show_days']) {
            case 1:
                $nb->setAvailTime(date("Y-m-d H:i:s", strtotime("+7 day")));
                break;
            case 2:
                $nb->setAvailTime(date("Y-m-d H:i:s", strtotime("+14 day")));
                break;
            case 3:
                $nb->setAvailTime(date("Y-m-d H:i:s", strtotime("+1 month")));
                break;
            case 4:
                $nb->setAvailTime(date("Y-m-d H:i:s", strtotime("+3 month")));
                break;
            case 5:
                $nb->setAvailTime(date("Y-m-d H:i:s", strtotime("+6 month")));
                break;
        }
        if (isset($data['remark'])) {
            $nb->setRemark($data['remark']);
        }
        if (!$nb->save()) {
            $this->db->rollback();
            return false;
        }
        //2.积分扣除
        if (!service('point/manager')->create($member, MemberPoint::TYPE_PUBLISH_NB, null, null, null, $nb->getId())) {
            $this->db->rollback();
            return false;
        }

        $this->db->commit();
        return $nb->getId();
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