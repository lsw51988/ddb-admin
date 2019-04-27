<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-6-5
 * Time: 下午2:48
 */

namespace Ddb\Modules;


use Ddb\Models\SecondBikes;

class SecondBike extends SecondBikes
{
    //1待审核 2审核通过 3审核拒绝 4自主取消 5成交 6时效过期
    const STATUS_CREATE = 1;
    const STATUS_AUTH = 2;
    const STATUS_DENIED = 3;
    const STATUS_CANCEL = 4;
    const STATUS_DEAL = 5;
    const STATUS_OUT_DATE = 6;

    public static $statusDesc = [
        self::STATUS_CREATE => "待审核",
        self::STATUS_AUTH => "审核通过",
        self::STATUS_DENIED => "审核拒绝",
        self::STATUS_CANCEL => "自主取消",
        self::STATUS_DEAL => "成交",
        self::STATUS_OUT_DATE => "时效过期"
    ];
}