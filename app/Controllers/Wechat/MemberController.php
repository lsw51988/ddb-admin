<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-23
 * Time: 下午7:53
 */

namespace Ddb\Controllers\Wechat;


use Ddb\Controllers\WechatAuthController;
use Ddb\Modules\SmsCode;

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
            $smsCodeData['token'] = $token;
            di("queue")->useTube("SmsCode")->put(serialize(['smsCode' => $smsCode, 'token' => $token]));
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

    }

}