<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-6-6
 * Time: 下午5:16
 */

namespace Ddb\Service\Area;


use Ddb\Core\Service;
use Ddb\Models\Provinces;
use Ddb\Models\Cities;
use Ddb\Models\Districts;

class Query extends Service
{
    public function getProvinces()
    {
        $provinces = Provinces::find();
        return $provinces;
    }

    public function getCities($province_code)
    {
        $cities = Cities::findByProvinceCode($province_code);
        return $cities;
    }

    public function getDistricts($city_code)
    {
        $districts = Districts::findByCityCode($city_code);
        return $districts;
    }
}