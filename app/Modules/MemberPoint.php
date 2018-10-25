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
    const TYPE_SIGN_WEEK = 15;
    const TYPE_SIGN_MONTH = 16;
    const TYPE_SIGN_YEAR = 17;
    const TYPE_RECHARGE_200 = 18;
    const TYPE_RECHARGE_500 = 19;
    const TYPE_RECHARGE_1000 = 20;

    const TYPE_SHOW_SHB_REFUSE = 21;
    const TYPE_PUBLISH_SHB_REFUSE = 22;
    const TYPE_PUBLISH_NB_REFUSE = 23;
    const TYPE_SHOW_NB_REFUSE = 24;

    const TYPE_PUBLISH_SHB = -1;
    const TYPE_CANCEL_APPEAL = -2;
    const TYPE_APPEAL_SOS = -3;
    const TYPE_LOST_BIKE = -4;
    const TYPE_UPDATE_SHB = -5;
    const TYPE_REPUB_SHB = -6;
    const TYPE_REFRESH_SHB = -7;
    const TYPE_REFRESH_NB = -8;
    const TYPE_PUBLISH_NB = -9;
    const TYPE_SHOW_NB = -10;
    const TYPE_SHOW_SHB = -11;

    const TYPE_PRIVILEGE_ONE_MONTH = -12;
    const TYPE_PRIVILEGE_THREE_MONTH = -13;
    const TYPE_PRIVILEGE_SIX_MONTH = -14;
    const TYPE_PRIVILEGE_TWELVE_MONTH = -15;


    const LEVEL_BRONZE = 500;
    const LEVEL_SILVER = 1000;
    const LEVEL_GOLD = 2000;
    const LEVEL_DIAMOND = 5000;
    const LEVEL_KING = 10000;

    public static $typeDesc = [
        self::TYPE_REGISTER => "注册",
        self::TYPE_SIGN => "每日签到",
        self::TYPE_SIGN_WEEK => "每周满签",
        self::TYPE_SIGN_MONTH => "每月满签",
        self::TYPE_SIGN_YEAR => "365天满签",
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
        self::TYPE_RECHARGE_50 => "充值50元",
        self::TYPE_RECHARGE_100 => "充值100元",
        self::TYPE_RECHARGE_200 => "充值200元",
        self::TYPE_RECHARGE_500 => "充值500元",
        self::TYPE_RECHARGE_1000 => "充值1000元",

        self::TYPE_PUBLISH_SHB => "发布二手车信息",
        self::TYPE_CANCEL_APPEAL => "取消帮助",
        self::TYPE_APPEAL_SOS => "无法移动,寻求帮助",
        self::TYPE_LOST_BIKE => "车辆丢失",
        self::TYPE_UPDATE_SHB => "更新二手车信息",
        self::TYPE_REPUB_SHB => "重新发布二手车",
        self::TYPE_REFRESH_SHB => "刷新二手车排名",
        self::TYPE_REFRESH_NB => "刷新新车排名",
        self::TYPE_PUBLISH_NB => "发布新车信息",
        self::TYPE_SHOW_NB => "展示新车信息",
        self::TYPE_SHOW_SHB => "展示二手车信息",

        self::TYPE_SHOW_SHB_REFUSE => "拒绝展示二手车信息",
        self::TYPE_PUBLISH_SHB_REFUSE => "拒绝发布二手车信息",
        self::TYPE_PUBLISH_NB_REFUSE => "拒绝展示新车信息",
        self::TYPE_SHOW_NB_REFUSE => "拒绝展示新车信息",
        self::TYPE_PRIVILEGE_ONE_MONTH => "一个月会员",
        self::TYPE_PRIVILEGE_THREE_MONTH => "三个月会员",
        self::TYPE_PRIVILEGE_SIX_MONTH => "半年会员",
        self::TYPE_PRIVILEGE_TWELVE_MONTH => "一年会员"
    ];

    public static $typeScore = [
        self::TYPE_REGISTER => 5,
        self::TYPE_SIGN => 2,
        self::TYPE_SIGN_WEEK => 10,
        self::TYPE_SIGN_MONTH => 20,
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
        self::TYPE_RECHARGE_50 => 520,
        self::TYPE_RECHARGE_100 => 1050,
        self::TYPE_RECHARGE_200 => 2100,
        self::TYPE_RECHARGE_500 => 5200,
        self::TYPE_RECHARGE_1000 => 10500,

        self::TYPE_SHOW_SHB_REFUSE => 10,
        self::TYPE_PUBLISH_SHB_REFUSE => 100,
        self::TYPE_PUBLISH_NB_REFUSE => 100,
        self::TYPE_SHOW_NB_REFUSE => 10,

        self::TYPE_PUBLISH_SHB => -100,
        self::TYPE_CANCEL_APPEAL => -10,
        self::TYPE_APPEAL_SOS => -10,
        self::TYPE_LOST_BIKE => -10,
        self::TYPE_UPDATE_SHB => -10,
        self::TYPE_REPUB_SHB => -100,
        self::TYPE_REFRESH_SHB => -10,
        self::TYPE_REFRESH_NB => -10,
        self::TYPE_PUBLISH_NB => -100,
        self::TYPE_SHOW_NB => -10,
        self::TYPE_SHOW_SHB => -10,

        self::TYPE_PRIVILEGE_ONE_MONTH => -100,
        self::TYPE_PRIVILEGE_THREE_MONTH => -280,
        self::TYPE_PRIVILEGE_SIX_MONTH => -520,
        self::TYPE_PRIVILEGE_TWELVE_MONTH => -1000
    ];

    //根据充值金额,返回具体的充值类型值
    public static function getRechargeType($amount)
    {
        $type = "";
        if ($amount == 10) {
            $type = self::TYPE_RECHARGE_10;
        }
        if ($amount == 50) {
            $type = self::TYPE_RECHARGE_50;
        }
        if ($amount == 100) {
            $type = self::TYPE_RECHARGE_100;
        }
        if ($amount == 200) {
            $type = self::TYPE_RECHARGE_200;
        }
        if ($amount == 500) {
            $type = self::TYPE_RECHARGE_500;
        }
        if ($amount == 1000) {
            $type = self::TYPE_RECHARGE_1000;
        }
        return $type;
    }

    //获取会员类型
    public static function getPrivilegeType($point)
    {
        if ($point == 100) {
            $type = self::TYPE_PRIVILEGE_ONE_MONTH;
        }
        if ($point == 280) {
            $type = self::TYPE_PRIVILEGE_THREE_MONTH;
        }
        if ($point == 520) {
            $type = self::TYPE_PRIVILEGE_SIX_MONTH;
        }
        if ($point == 1000) {
            $type = self::TYPE_PRIVILEGE_TWELVE_MONTH;
        }
        return $type;
    }

    //获取会员充值月数
    public static function getPrivilegeMonth($point)
    {
        if ($point == 100) {
            $month = 1;
        }
        if ($point == 280) {
            $month = 3;
        }
        if ($point == 520) {
            $month = 6;
        }
        if ($point == 1000) {
            $month = 12;
        }
        return $month;
    }

    //根据选择展示天数key获取对应天数
    public static function getShowDays($index)
    {
        $days = 0;
        switch ($index) {
            case 1:
                $days = 7;
                break;
            case 2:
                $days = 14;
                break;
            case 3:
                $days = 30;
                break;
            case 4:
                $days = 90;
                break;
            case 5:
                $days = 180;
                break;
            case 6:
                $days = 365;
                break;
        }
        return $days;
    }

    public function getShowDaysByPoints($memberPoint)
    {
        $points = $memberPoint->getValue();
        $member = Member::findFirst($memberPoint->getMemberId());
        if (service('member/query')->isPrivilege($member)) {
            $days = $points / 8;
        } else {
            $days = $points / 10;
        }
        return $days;
    }

}