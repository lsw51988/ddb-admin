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
        $data['voltage'] = MemberBike::$voltageDesc[$data['voltage'] + 1];
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
            app_log()->info("创建二手车时，获取地址信息失败：省==" . $data['province'] . " 市==" . $data['city'] . " 区==" . $data['district']);
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
            $shb->setLastChangeTime($data['last_change_time'] . "-01 00:00:00");
        }

        //2.积分扣除 发布二手车的积分
        //如果小于3辆车，则不扣除积分
        $secondBikeCount = SecondBike::count('member_id = ' . $member->getId());
        if ($secondBikeCount > 3) {
            if (!service('point/manager')->create($member, MemberPoint::TYPE_PUBLISH_SHB, $shb->getId())) {
                $this->db->rollback();
                return false;
            }
        }
        //3.消息通知
        if (!service('member/manager')->saveMessage($member->getId(), '发布二手车成功')) {
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
        if ($area = Areas::findFirst("province_name='" . $data['province'] . "' AND city_name='" . $data['city'] . "' AND district_name='" . $data['district'] . "'")) {
            $shb->setProvinceCode($area->getProvinceCode())
                ->setCityCode($area->getCityCode())
                ->setDistrictCode($area->getDistrictCode());
        } else {
            app_log()->info("更新二手车时，获取地址信息失败：省==" . $data['province'] . " 市==" . $data['city'] . " 区==" . $data['district']);
        }
        if (isset($data['remark'])) {
            $shb->setRemark($data['remark']);
        }
        if (isset($data['last_change_time']) && $data['last_change_time'] != "未更换") {
            $shb->setLastChangeTime($data['last_change_time']);
        }

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
        $this->db->commit();
        return $shb->getId();
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
        if ($secondBikeBrowse) {
            $secondBikeBrowse->setCallTime(date("Y-m-d H:i:s", time()))->save();
        }
    }

    public function returnPoints($member, $shb)
    {
        //2.积分取消扣除 发布二手车的积分
        if (!service('point/manager')->create($member, MemberPoint::TYPE_PUBLISH_SHB_REFUSE, $shb->getId())) {
            return false;
        }
        return true;
    }
}