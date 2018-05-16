<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-16
 * Time: 下午11:19
 */

namespace Ddb\Servive\SHB;


use Ddb\Core\Service;
use Ddb\Models\SecondBikes;
use Ddb\Modules\MemberPoint;

class Manager extends Service
{
    public function create($member, $data)
    {
        $this->db->begin();
        $shb = new SecondBikes();
        $shb->setMemberId($member->getId())
            ->setBuyDate($data['buy_date'])
            ->setVoltage($data['voltage'])
            ->setBrandName($data['brand_name'])
            ->setInPrice($data['in_price'])
            ->setOutPrice($data['out_price'])
            ->setProvince($data['addr'][0])
            ->setCity($data['addr'][1])
            ->setDistrict($data['addr'][2])
            ->setNumber($data['number']);
        if (isset($data['remark'])) {
            $shb->setRemark($data['remark']);
        }
        if (!$shb->save()) {
            $this->db->rollback();
            return false;
        }
        //扣除积分
        if (service("point/manager")->create($member, MemberPoint::TYPE_PUBLISH_SHB, $shb->getId())) {
            $this->db->commit();
            return $shb->getId();
        } else {
            return false;
        }
    }



}