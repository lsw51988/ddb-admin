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
        "0" => 48,
        "1" => 60,
        "2" => 72,
        "3" => 96,
        "4" => 1
    ];
}