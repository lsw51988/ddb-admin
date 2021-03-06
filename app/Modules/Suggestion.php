<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-29
 * Time: 下午3:06
 */

namespace Ddb\Modules;


use Ddb\Models\Suggestions;

class Suggestion extends Suggestions
{
    const STATUS_CREATE = 1;
    const STATUS_REFUSE = 2;
    const STATUS_ACCEPT = 3;

    const TYPE_MEMBER_DETAIL = 0;
    const TYPE_FIX_AUTH = 1;
    const TYPE_APPEAL = 2;
    const TYPE_LOST_APPEAL = 3;
    const TYPE_POINT = 4;
    const TYPE_SHB = 5;
    const TYPE_RECOMMEND = 6;

    public static $statusDesc = [
        self::STATUS_CREATE=>'刚创建',
        self::STATUS_REFUSE=>'拒绝',
        self::STATUS_ACCEPT=>'通过',
    ];

    public static $typeDesc = [
        self::TYPE_MEMBER_DETAIL => "用户完善资料",
        self::TYPE_FIX_AUTH => "修理者认证",
        self::TYPE_APPEAL => "求助",
        self::TYPE_LOST_APPEAL => "丢失求助",
        self::TYPE_POINT => "积分充值",
        self::TYPE_SHB => "二手车",
        self::TYPE_RECOMMEND => "推荐"
    ];
}