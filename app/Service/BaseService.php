<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-18
 * Time: 下午11:44
 */

namespace Ddb\Service;


use Ddb\Core\Service;

class BaseService extends Service
{
    private static $times = 5;

    public function getLocation($latitude, $longitude)
    {
        $url = "http://apis.map.qq.com/ws/geocoder/v1?location=" . $latitude . "," . $longitude . "&key=" . di("config")->app->tecent_addr_key;
        $curl_data = curl_request($url);
        $curl_data = json_decode($curl_data);
        if ($curl_data->status == 0) {
            return $curl_data;
        } else {
            self::$times--;
            if (self::$times > 0) {
                $this->getLocation($latitude, $longitude);
            } else {
                return null;
            }
        }
    }
}