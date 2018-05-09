<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-5
 * Time: 下午2:43
 */

namespace Ddb\Modules;

use Ddb\Models\MemberPoints;

class MemberPoint extends MemberPoints
{
    const TYPE_REGISTER = 1;
    const TYPE_FIRST_OPEN = 2;
    const TYPE_AUTH = 3;
    const TYPE_ADD_REPAIRS = 4;
    const TYPE_NEW_PAGE = 5;
    const TYPE_SUGGESTION = 6;
    const TYPE_SUGGESTION_APPROVED = 7;
    const TYPE_RECOMMEND = 8;
    const TYPE_SCORE = 9;
    const TYPE_APPEAL = 10;
    const TYPE_APPEAL_CALLBACK = 11;
    const TYPE_RECHARGE_10 = 12;
    const TYPE_RECHARGE_50 = 13;
    const TYPE_RECHARGE_100 = 14;

    const TYPE_PUBLISH_SHB = -1;
    const TYPE_CANCEL_APPEAL = -2;

    public static $typeDesc = [
        self::TYPE_REGISTER => "注册",
        self::TYPE_FIRST_OPEN => "每日打开第一次",
        self::TYPE_AUTH => "用户完善信息",
        self::TYPE_ADD_REPAIRS => "增加维修点",
        self::TYPE_NEW_PAGE => "第一次探索新的页面",
        self::TYPE_SUGGESTION => "提出建议",
        self::TYPE_SUGGESTION_APPROVED => "提出建议被采纳",
        self::TYPE_RECOMMEND => "推荐奖励",
        self::TYPE_SCORE => "评分",
        self::TYPE_APPEAL => "完成应答",
        self::TYPE_APPEAL_CALLBACK => "提交回访单",
        self::TYPE_RECHARGE_10 => "充值10元",
        self::TYPE_RECHARGE_50 => "充值20元",
        self::TYPE_RECHARGE_100 => "充值50元",

        self::TYPE_PUBLISH_SHB => "发布二手车信息",
        self::TYPE_CANCEL_APPEAL => "取消帮助",
    ];

    public static $typeScore = [
        self::TYPE_REGISTER => 5,
        self::TYPE_FIRST_OPEN => 1,
        self::TYPE_AUTH => 5,
        self::TYPE_ADD_REPAIRS => 10,
        self::TYPE_NEW_PAGE => 1,
        self::TYPE_SUGGESTION => 2,
        self::TYPE_SUGGESTION_APPROVED => 2,
        self::TYPE_RECOMMEND => 2,
        self::TYPE_SCORE => 2,
        self::TYPE_APPEAL => 2,
        self::TYPE_APPEAL_CALLBACK => 2,
        self::TYPE_RECHARGE_10 => 100,
        self::TYPE_RECHARGE_50 => 600,
        self::TYPE_RECHARGE_100 => 1200,

        self::TYPE_PUBLISH_SHB => -100,
        self::TYPE_CANCEL_APPEAL => -10,
    ];

}