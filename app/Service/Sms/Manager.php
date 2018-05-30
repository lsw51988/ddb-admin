<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-29
 * Time: 下午2:48
 */

namespace Ddb\Service\Sms;

use Ddb\Core\Service;
use Ddb\Modules\SmsCode;
use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use Phalcon\Exception;


Config::load();

class Manager extends Service
{
    static $acsClient = null;

    /**
     * 取得AcsClient
     *
     * @return DefaultAcsClient
     */
    public static function getAcsClient()
    {
        //产品名称:云通信流量服务API产品,开发者无需替换
        $product = "Dysmsapi";

        //产品域名,开发者无需替换
        $domain = "dysmsapi.aliyuncs.com";

        // TODO 此处需要替换成开发者自己的AK (https://ak-console.aliyun.com/)
        $accessKeyId = SmsCode::SMS_KEY; // AccessKeyId

        $accessKeySecret = SmsCode::SMS_KEY_SECRET; // AccessKeySecret

        // 暂时不支持多Region
        $region = "cn-hangzhou";

        // 服务结点
        $endPointName = "cn-hangzhou";


        if (static::$acsClient == null) {

            //初始化acsClient,暂不支持region化
            $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);

            // 增加服务结点
            DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);

            // 初始化AcsClient用于发起请求
            static::$acsClient = new DefaultAcsClient($profile);
        }
        return static::$acsClient;
    }


    public function send($smsCodeId, $token = null)
    {
        //需要从缓存中进行判断是否具有发送短信资格,防止暴力调用接口
        if ($token != null && !di("cache")->get($token . "_tcgmc")) {
            return false;
        }
        $smsCode = SmsCode::findFirst($smsCodeId);
        if ($smsCode->getStatus() == SmsCode::STATUS_SUCCESS) {
            return false;
        }
        //本地环境不发送
        if (APP_ENV != "local") {
            // 初始化SendSmsRequest实例用于设置发送短信的参数
            $request = new SendSmsRequest();

            //可选-启用https协议
            //$request->setProtocol("https");

            // 必填，设置短信接收号码
            $request->setPhoneNumbers($smsCode->getMobile());

            // 必填，设置签名名称，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
            $request->setSignName("电动帮");

            // 必填，设置模板CODE，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
            $request->setTemplateCode($smsCode->getTemplate());

            // 可选，设置模板参数, 假如模板中存在变量需要替换则为必填项
            $request->setTemplateParam(json_encode(array(  // 短信模板中字段的值
                "code" => $smsCode->getCode()
            ), JSON_UNESCAPED_UNICODE));

            // 可选，设置流水号
            ///$request->setOutId("yourOutId");

            // 选填，上行短信扩展码（扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段）
            //$request->setSmsUpExtendCode("1234567");

            // 发起访问请求
            try {
                $acsResponse = static::getAcsClient()->getAcsResponse($request);
                if ($acsResponse->Message == "OK") {
                    $smsCode->setStatus(SmsCode::STATUS_SUCCESS)->save();
                } else {
                    $smsCode->setStatus(SmsCode::STATUS_FAIL)->save();
                }
                app_log("queue")->info("发送成功,smsCodeId=" . $smsCode->getId()."走的qa");
                return true;
            } catch (Exception $e) {
                $smsCode->setStatus(SmsCode::STATUS_FAIL)->save();
                app_log("queue")->error("发送失败,smsCodeId=" . $smsCode->getId() . "原因是:" . $e->getMessage());
                return false;
            }
        } else {
            if ($result = $smsCode->setStatus(SmsCode::STATUS_SUCCESS)->save()) {
                app_log("queue")->info("发送成功,smsCodeId=" . $smsCode->getId()."走的本地");
                return true;
            } else {
                app_log("queue")->error("发送失败,smsCodeId=" . $smsCode->getId() . "原因是:数据库保存状态失败");
                return false;
            }
        }
    }

    public function getSmsCode()
    {
        if (APP_ENV == "local") {
            return '1234';
        } else {
            return rand(1000, 9999);
        }
    }

    public function verify($mobile, $smsCode)
    {
        if (di("cache")->get($mobile . "_auth") != $smsCode) {
            return false;
        } else {
            di("cache")->delete($mobile . "_auth");
            return true;
        }
    }

    public function create($mobile, $code, $template, $status = 1)
    {
        $smsCode = new SmsCode();
        $smsCode->setMobile($mobile)
            ->setTemplate($template)
            ->setCode($code);
        if ($smsCode->save()) {
            return $smsCode;
        } else {
            return false;
        }
    }

    //每日发送短信上限为10条
    public function canSend($mobile)
    {
        if (SmsCode::count("mobile=" . $mobile . " AND created_at>='" . Date("Y-m-d 00:00:00", time()) . "'") > 10) {
            return false;
        }
        return true;
    }
}