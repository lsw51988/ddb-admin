<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-18
 * Time: 下午11:43
 */

namespace Ddb\Service\Member;


use Ddb\Models\MemberBikeImages;
use Ddb\Models\MemberLocations;
use Ddb\Modules\Member;
use Ddb\Service\BaseService;
use Ddb\Models\Members;
use Phalcon\Exception;
use Ddb\Helper\Wechat\WXBizDataCrypt;


class Manager extends BaseService
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

    public function getWechatLogin($js_code)
    {
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . di("config")->app->APP_ID . '&secret=' . di("config")->app->APP_SECRET . '&js_code=' . $js_code . '&grant_type=authorization_code';
        $curl_data = json_decode(curl_request($url));
        return $curl_data;
    }

    public function saveLocation(Members $member, $location)
    {
        $memberLocation = new MemberLocations();//记录用户常用的地址
        $memberLocation->setMemberId($member->getId())
            ->setLatitude($location->result->location->lat)
            ->setLongitude($location->result->location->lng)
            ->setAddress($location->result->address)
            ->setProvince($location->result->address_component->province)
            ->setCity($location->result->address_component->city)
            ->setDistrict($location->result->address_component->district)
            ->setStreet($location->result->address_component->street)
            ->setStreetNumber($location->result->address_component->street_number);
        if (!$memberLocation->save()) {
            return false;
        }
        return true;
    }

    public function updateAvatar(Member $member, $file)
    {
        if ($avatarUrl = $member->getAvatarUrl()) {
            try {
                service("file/manager")->deleteFile($avatarUrl);
            } catch (Exception $e) {
                return false;
            }
        }

        $path = "AvatarImages/" . $member->getId() . '-' . $file['file']['name'];
        try {
            service("file/manager")->saveFile($path, $file['file']['tmp_name']);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getDecryptData($memberId, $appid, $sessionKey, $encryptedData, $iv)
    {
        $pc = new WXBizDataCrypt($appid, $sessionKey);
        $errCode = $pc->decryptData($encryptedData, $iv, $data);
        if ($errCode == 0) {
            di("cache")->delete($memberId . "_sessionKey");
            return json_decode($data);
        } else {
            return false;
        }
    }

}