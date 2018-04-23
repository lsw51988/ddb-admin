<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-23
 * Time: 下午7:53
 */

namespace Ddb\Controllers\Wechat;


use Ddb\Controllers\WechatAuthController;

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
    public function authAction(){

    }

    /**
     * @Get("/smsCode")
     * 获取短信验证码
     */
    public function smsCodeAction(){

    }

    /**
     * @Post("/upload")
     * 上传电车照片
     */
    public function uploadAction(){

    }

}