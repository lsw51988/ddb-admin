<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-29
 * Time: 下午3:00
 */

namespace Ddb\Modules;


use Ddb\Models\SmsCodes;

class SmsCode extends SmsCodes
{
    const SMS_KEY = "LTAIXAKPzxi0LLnu";
    const SMS_KEY_SECRET = "qokcowMiTiW7Hv2SmOxXY2cUBO4udB";

    const STATUS_SENDING = 1;
    const STATUS_SUCCESS = 2;
    const STATUS_FAIL = 3;

    //通用模板 ${code}，5分钟内有效！
    const TEMPLATE_INDEX = "SMS_133270990";

}