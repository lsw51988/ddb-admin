<?php
/**
 * Created by PhpStorm.
 * User: 阿德
 * Date: 2018/4/15
 * Time: 17:40
 */

namespace Ddb\Controllers\Wechat;

use Ddb\Core\BaseController;
use Ddb\Helper\Captcha;
use Ddb\Models\Areas;
use Ddb\Models\Members;
use Ddb\Modules\Member;
use Ddb\Models\MemberLocations;
use Ddb\Modules\MemberPoint;

/**
 * Class IndexController
 * @package Ddb\Controllers\Wechat
 * @RoutePrefix("/wechat")
 */
class IndexController extends BaseController
{
    /**
     * @Post("/index")
     * 用户首次进入逻辑-->改版后不进行注册，否则陌生用户太多，只根据js_code记录session_key
     * 1.没有该用户，注册
     * 2.返回该用户信息
     */
    public function indexAction()
    {
        $data = $this->data;
        $wechatLogin = service("member/manager")->getWechatLogin($data['js_code']);
        $openId = $wechatLogin->openid;
        $sessionKey = $wechatLogin->session_key;
        $location = service("member/manager")->getLocation($data['latitude'], $data['longitude']);
        $token = md5($data['js_code'] . time() . rand(0, 9999));
        if (!$member = Members::findFirstByOpenId($openId)) {
            $data['open_id'] = $openId;
            //1.根据经纬度获取用户的当前地址
            if ($location->status != 0) {
                return $this->success($location);
                $data['province'] = "未知";
                $data['city'] = "未知";
                $data['district'] = "未知";
            } else {
                $area = Areas::findFirstByDistrictName($location->result->address_component->district);
                $data['province'] = $area->getProvinceCode();
                $data['city'] = $area->getCityCode();
                $data['district'] = $area->getDistrictCode();
            }
            $member = new Members();
            $data['token'] = $token;
            $data['token_time'] = date("Y-m-d H:i:s", strtotime("+1 month"));
            if (!$member->save($data)) {
                return $this->error("用户数据保存错误");
            }
            di("cache")->save($data['token'], serialize($member), 30 * 24 * 3600);
            if ($data['share_member_id'] != "" && $data['share_member_id'] != $member->getId()) {
                service("recommend/manager")->create($data['share_member_id'], $member->getId());
                $tMember = Member::findFirst($data['share_member_id']);
                service("point/manager")->create($tMember, MemberPoint::TYPE_RECOMMEND);
            }
        } else {
            if (!di("cache")->get($member->getToken())) {
                $member->setToken($token)
                    ->setTokenTime(date("Y-m-d H:i:s", strtotime("+1 month")))
                    ->save();
                di("cache")->save($token, serialize($member), 30 * 24 * 60);
            }
        }
        if (!$member->getUnionId()) {
            di("cache")->save($member->getId() . '_sessionKey', $sessionKey, 30 * 24 * 3600);
        }
        if ($location->status == 0) {
            service("member/manager")->saveLocation($member, $location);
            $repairFlag = service("member/query")->isRepair($member);
            $unionFlag = $member->getUnionId() == null ? false : true;
            return $this->success([
                "token" => $member->getToken(),
                "avatarUrl" => $member->getAvatarUrl(),
                "nickName" => $member->getNickName(),
                "auth_time" => $member->getAuthTime(),
                "mobile" => $member->getMobile(),
                "id" => $member->getId(),
                "union_flag" => $unionFlag,
                "repair_flag" => $repairFlag,
                "location" => [$location->result->address_component->province, $location->result->address_component->city, $location->result->address_component->district]
            ]);
        } else {
            return $this->success($location);
        }
    }

    /**
     * @Get("/qr_code")
     * 获取公众号二维码
     */
    public function qr_codeAction()
    {
        ob_clean();
        header("Content-type:image/jpeg");
        echo file_get_contents(APP_PATH . '/../public/img/qr_code.jpg', true);
    }

    /**
     * @Get("/captcha")
     * 获取验证码
     */
    public function captchaAction()
    {
        $data = $this->data;
        $token = $data['token'];
        $key = $token . 'captcha';
        $_vc = new Captcha();
        $_vc->doimg();
        di("cache")->save($key, $_vc->getCode(), 300);
    }

    /**
     * 验证图形验证码
     * @Post("/verifyCaptcha")
     */
    public function verifyCaptchaAction()
    {
        $data = $this->data;
        $captcha = $data['captcha'];
        $token = $this->request->getHeader("token");
        $key = $token . 'captcha';
        if ($captcha == di("cache")->get($key)) {
            di("cache")->delete($key);
            //tcgmc = tokenCanGetMobileCode
            $tcgmcKey = $token . "_tcgmc";
            di("cache")->save($tcgmcKey, 1, 300);
            return $this->success();
        }
        return $this->error();
    }

    /**
     * @Get("/avatar")
     * 获取用户头像
     */
    public function avatarAction()
    {
        $data = $this->data;
        $path = $data['path'];
        $data = service("file/manager")->read($path);
        return $this->response->setContent($data['contents'])->setContentType('image/jpeg');
    }

    /**
     * @Post("/checkToken")
     * 检查token是否有效
     */
    public function checkTokenAction()
    {
        $token = $this->request->getHeader("token");
        $data = $this->data;
        $memberId = $data['member_id'];
        if (di('cache')->get($token)) {
            return $this->success();
        } else {
            //说明此时后端的token已经过期,此时应该产生新的token,并将原有的token删除,防止token的值一直不变
            $member = Member::findFirst($memberId);
            $memberLocation = MemberLocations::findFirst([
                "conditions" => "member_id = $memberId",
                "order" => "created_at DESC"
            ]);
            $unionFlag = $member->getUnionId() == null ? false : true;
            $rData = [];
            $rData['auth_time'] = $member->getAuthTime();
            $rData['avatarUrl'] = $member->getAvatarUrl();
            $rData['id'] = $data['id'];
            $rData['mobile'] = $member->getMobile();
            $rData['nickName'] = $member->getNickName();
            $rData['token'] = $member->getToken();
            $rData['union_flag'] = $unionFlag;
            $rData['location'] = [$memberLocation->getProvince(), $memberLocation->getCity(), $memberLocation->getDistrict()];
            return $this->error($rData);
        }
    }
}