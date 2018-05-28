<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-28
 * Time: 上午12:54
 */

namespace Ddb\Service\Repair;


use Ddb\Core\Service;
use Ddb\Modules\Repair;

class Query extends Service
{
    /**
     * @param $longitude
     * @param $latitude
     * @param $radius
     *
     *  在经线上,相差一纬度约为111km 这里将距离放大一点比为105KM
     * 在纬线上,相差一经度约为111cosαKM（α为该纬线的纬度）同上改为105KM
     * 半径单位为米,默认是1000米
     */
    public function getNearMtsByRadius($longitude, $latitude, $radius = 1000)
    {
        $minLong = round($longitude - $radius / 1000 / 105, 5);
        $maxLong = round($longitude + $radius / 1000 / 105, 5);
        $minLati = round($latitude - $radius / 1000 / 105 / cos($latitude), 5);
        $maxLati = round($latitude + $radius / 1000 / 105 / cos($latitude), 5);

        $mts = Repair::find([
            "columns"=>"longitude,latitude,name,address,belonger_name,id",
            "conditions"=> "longitude >= :minLong: AND longitude<= :maxLong: AND latitude>=:minLati: AND latitude <= :maxLati:",
            "bind"=>[
                "minLong"=>$minLong,
                "maxLong"=>$maxLong,
                "minLati"=>$minLati,
                "maxLati"=>$maxLati,
                //"status"=>Repair::STATUS_NOT_OWNER_CREATE,
            ]
        ]);
        $mts = $mts->toArray();
        return $mts;
    }

}