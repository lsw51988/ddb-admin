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
    const TYPE_SIGN = 2;
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
    const TYPE_APPEAL_SOS = -3;
    const TYPE_LOST_BIKE = -4;
    const TYPE_UPDATE_SHB = -5;
    const TYPE_REPUB_SHB = -6;
    const TYPE_REFRESH_SHB = -7;
    const TYPE_REFRESH_NB = -8;

    const LEVEL_BRONZE = 500;
    const LEVEL_SILVER = 1000;
    const LEVEL_GOLD = 2000;
    const LEVEL_DIAMOND = 5000;
    const LEVEL_KING = 10000;

    public static $typeDesc = [
        self::TYPE_REGISTER => "注册",
        self::TYPE_SIGN => "每日签到",
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
        self::TYPE_APPEAL_SOS => "无法移动,寻求帮助",
        self::TYPE_LOST_BIKE => "车辆丢失",
        self::TYPE_UPDATE_SHB => "更新二手车信息",
        self::TYPE_REPUB_SHB => "重新发布二手车",
        self::TYPE_REFRESH_SHB => "刷新二手车排名",
        self::TYPE_REFRESH_NB => "刷新新车排名",
    ];

    public static $typeScore = [
        self::TYPE_REGISTER => 5,
        self::TYPE_SIGN => 2,
        self::TYPE_AUTH => 5,
        self::TYPE_ADD_REPAIRS => 10,
        self::TYPE_NEW_PAGE => 2,
        self::TYPE_SUGGESTION => 2,
        self::TYPE_SUGGESTION_APPROVED => 2,
        self::TYPE_RECOMMEND => 10,
        self::TYPE_SCORE => 2,
        self::TYPE_APPEAL => 2,
        self::TYPE_APPEAL_CALLBACK => 2,
        self::TYPE_RECHARGE_10 => 100,
        self::TYPE_RECHARGE_50 => 600,
        self::TYPE_RECHARGE_100 => 1200,

        self::TYPE_PUBLISH_SHB => -100,
        self::TYPE_CANCEL_APPEAL => -10,
        self::TYPE_APPEAL_SOS => -10,
        self::TYPE_LOST_BIKE => -10,
        self::TYPE_UPDATE_SHB => -10,
        self::TYPE_REPUB_SHB => -100,
        self::TYPE_REFRESH_SHB => -10,
        self::TYPE_REFRESH_NB => -10,
    ];

    //根据充值金额,返回具体的充值类型值
    public static function getRechargeType($amount)
    {
        $type = "";
        if ($amount == 10) {
            $type = MemberPoint::TYPE_RECHARGE_10;
        }
        if ($amount == 50) {
            $type = MemberPoint::TYPE_RECHARGE_50;
        }
        if ($amount == 100) {
            $type = MemberPoint::TYPE_RECHARGE_100;
        }
        return $type;
    }

}