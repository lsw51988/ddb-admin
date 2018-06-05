<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-16
 * Time: 下午11:47
 */

namespace Ddb\Service\Shb;


use Ddb\Core\Service;
use Ddb\Modules\MemberPoint;
use Ddb\Models\Areas;
use Ddb\Modules\SecondBike;

class Query extends Service
{
    public function hasEnoughPoint($member)
    {
        if ($member->getPoints() < abs(MemberPoint::$typeScore[MemberPoint::TYPE_PUBLISH_SHB])) {
            return false;
        }
        return true;
    }

    public function getList($search = [])
    {
        $columns = "id,brand_name,out_price,city,district";
        $conditions = "1=1";
        if (!empty($search['time'])) {
            switch ($search['time']) {
                case 1:
                    $conditions = " AND created>='" . date("Y-m-d 00:00:00") . "' AND created<='" . date("Y-m-d 23:59:59") . "'";
                    break;
                case 2:
                    $conditions = " AND created>='" . date("Y-m-d 00:00:00", strtotime("-7 day")) . "' AND created<='" . date("Y-m-d 23:59:59") . "'";
                    break;
                case 3:
                    $conditions = " AND created>='" . date("Y-m-d 00:00:00", strtotime("-1 month")) . "' AND created<='" . date("Y-m-d 23:59:59") . "'";
                    break;
            }
        }

        if (!empty($search['district'])) {
            $conditions = " AND district=" . $search['district'];
        }
        $order = "";
        if (!empty($search['price'])) {
            switch ($search['time']) {
                case 1:
                    $order = "out_price ACS";
                    break;
                case 2:
                    $order = "out_price DESC";
                    break;
            }
        }
        $data = SecondBike::page($columns, $conditions, [], $order);
        return $data;
    }
}