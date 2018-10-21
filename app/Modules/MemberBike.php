<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-4
 * Time: 下午5:54
 */

namespace Ddb\Modules;


use Ddb\Models\MemberBikes;

class MemberBike extends MemberBikes
{
    const STATUS_NEW = 1;
    const STATUS_OLD = 2;

    //1代表其他  电压
    public static $voltageDesc = [
        "1" => 48,
        "2" => 60,
        "3" => 72,
        "4" => 96,
        "5" => 1
    ];
}