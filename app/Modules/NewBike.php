<?php
/**
 * Created by PhpStorm.
 * User: 阿德
 * Date: 2018/10/21
 * Time: 19:28
 */

namespace Ddb\Modules;


use Ddb\Models\NewBikes;

class NewBike extends NewBikes
{
    //1刚创建待审核 2审核通过 3审核拒绝 4自主取消 5时效过期
    const STATUS_CREATE = 1;
    const STATUS_AUTH = 2;
    const STATUS_DENIED = 3;
    const STATUS_CANCEL = 4;
    const STATUS_OUT_DATE = 5;

    public static $statusDesc = [
        self::STATUS_CREATE => "刚创建待审核",
        self::STATUS_AUTH => "审核通过",
        self::STATUS_DENIED => "审核拒绝",
        self::STATUS_CANCEL => "自主取消",
        self::STATUS_OUT_DATE => "时效过期"
    ];
}