<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-23
 * Time: 下午7:53
 */

namespace Ddb\Controllers\Wechat;


use Ddb\Controllers\WechatAuthController;
use Ddb\Modules\Member;
use Ddb\Modules\MemberBike;
use Ddb\Modules\MemberPoint;
use Ddb\Modules\SmsCode;
use League\Flysystem\Config;

/**
 * Class MemberController
 * 维修点CUR操作
 * @RoutePrefix("/wechat/member")
 */
class MemberController extends WechatAuthController
{
    /**
     * @Post("/auth")
     * 用户完善重要信息
     */
    public function authAction()
    {
        $data = $this->data;
        $mustKeys = [
            "real_name" => "姓名",
            "mobile" => "手机号",
            "sms_code" => "短信验证码",
            "brand_name" => "品牌",
            "buy_date" => "购买日期",
            "number" => "车牌号",
            "voltage" => "电池容量",
            "price" => "价格",
            "status" => "购买时状态"
        ];
        foreach ($mustKeys as $k => $v) {
            if ($data[$k] == "") {
                return $this->error($v . "是必填项:");
            }
        }
        $data['voltage'] = MemberBike::$voltageDesc[$data['voltage']];
        $data['buy_date'] = $data['buy_date'] . "-01";
        if ($data['last_change_time']) {
            $data['last_change_time'] = $data['last_change_time'] . "-01";
        }
        //验证短信验证码
        if (di("cache")->get($data['mobile'] . "_auth") != $data['sms_code']) {
            return $this->error("短信验证码不正确");
        }
        $memberId = $this->currentMember->getId();
        $member = Member::findFirst($memberId);
        $this->db->begin();
        $member->setRealName($data['real_name'])
            ->setMobile($data['mobile'])
            ->setAuthTime(date("Y-m-d H:i:s",time()));

        if (!$member->save()) {
            $this->db->rollback();
            return $this->error("个人用户信息保存失败");
        }
        $memberBike = new MemberBike();
        $memberBike->setMemberId($member->getId())
            ->setBrandName($data['brand_name'])
            ->setBuyDate($data['buy_date'])
            ->setNumber($data['number'])
            ->setVoltage($data['voltage'])
            ->setPrice($data['price'])
            ->setStatus($data['status']);
        if (!empty($data['last_change_time'])) {
            $memberBike->setLastChangeTime($data['last_change_time']);
        }
        if (!$memberBike->save()) {
            $this->db->rollback();
            return $this->error("个人用户车辆信息保存失败");
        }
        if (!service("point/manager")->create($member, MemberPoint::TYPE_AUTH)) {
            return $this->error("积分变更失败");
        }
        $this->db->commit();

        //需要重写缓存
        $token = $this->token;
        service("member/manager")->freshCache($token,$member);
        return $this->success();
    }

    /**
     * @Get("/auth")
     * 获取用户的重要信息
     */
    public function authShowAction(){
        $currentMember = $this->currentMember;
        $data = service("member/query")->getAuthInfo($currentMember);
        return $this->success($data);
    }

    /**
     * @Post("/smsCode")
     * 获取短信验证码
     */
    public function smsCodeAction()
    {
        $token = $this->token;
        $data = $this->data;
        $code = service("sms/manager")->getSmsCode();
        $smsCode = new SmsCode();
        $smsCodeData['mobile'] = $data['mobile'];
        $smsCodeData['code'] = $code;
        $smsCodeData['status'] = SmsCode::STATUS_SENDING;
        $smsCodeData['template'] = SmsCode::TEMPLATE_INDEX;

        if ($smsCode->save($smsCodeData)) {
            $key = $data['mobile'] . "_auth";
            di("cache")->save($key, $code, 5 * 60);
            di("queue")->useTube("SmsCode")->put(serialize(['smsCodeId' => $smsCode->getId(), 'token' => $token]));
            return $this->success("发送成功");
        } else {
            return $this->error("发送失败");
        }
    }

    /**
     * @Post("/smsCodeVerify")
     * 验证短信验证码
     */
    public function smsCodeVerifyAction()
    {
        $data = $this->data;
        if ($authValue = di("cache")->get($data["mobile"] . "_auth")) {
            if ($authValue == $data['code']) {
                di("cache")->delete($data["mobile"] . "_auth");
                return $this->success();
            } else {
                return $this->error("不匹配");
            }
        } else {
            return $this->error("请重新获取");
        }
    }

    /**
     * @Post("/upload")
     * 上传电车照片
     */
    public function uploadAction()
    {
        $file = $_FILES;
        service("file/manager")->saveFile($file['file']['name'],$file['file']['tmp_name']);
    }

}