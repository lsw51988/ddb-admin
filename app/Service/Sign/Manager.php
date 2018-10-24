<?php
namespace Ddb\Service\Sign;

use Ddb\Models\MemberSignCollects;
use Ddb\Models\MemberSigns;
use Ddb\Modules\Member;
use Ddb\Modules\MemberPoint;
use Ddb\Service\BaseService;

/**
 * Created by PhpStorm.
 * User: 阿德
 * Date: 2018/10/25
 * Time: 0:13
 */
class Manager extends BaseService
{
    public function sign($member)
    {
        $this->db->begin();
        $memberSign = new MemberSigns();
        $memberSign->setMemberId($member->getId())
            ->setDay(date('Y-m-d'))
            ->setWeek(date('W'));
        if (!$memberSign->save()) {
            $this->db->rollback();
            return false;
        }
        $memberSignCollect = new MemberSignCollects();
        $memberSignCollect->setMemberId($member->getId());
        //签到逻辑 本周第一天则week_count=1 本月第一天month_count=1 查看前一天是否签到如果签到，且不是周期第一天，则+1
        //每个月的第N天
        $yesterdayFlag = false;
        $msg = '签到成功，获取2积分';
        if (date('j') == 1) {
            $memberSignCollect->setMonthCount(1);
        } else {
            if (MemberSigns::findFirst('member_id = ' . $member->getId() . ' AND day = \'' . date('Y-m-d', strtotime('-1 day')) . '\'')) {
                $yesterdayFlag = true;
                $memberSignCollect->setMonthCount($memberSignCollect->getMonthCount() + 1);
            }
        }
        //每周的第N天
        if (date('N') == 1) {
            $memberSignCollect->setWeekCount(1);
        } else {
            if (MemberSigns::findFirst('member_id = ' . $member->getId() . ' AND day = \'' . date('Y-m-d', strtotime('-1 day')) . '\'')) {
                $yesterdayFlag = true;
                $memberSignCollect->setWeekCount($memberSignCollect->getWeekCount() + 1);
            }
        }
        if ($yesterdayFlag) {
            $memberSignCollect->setContinueCount($memberSignCollect->getContinueCount() + 1);
        } else {
            $memberSignCollect->setContinueCount(1);
        }
        $memberSignCollect->setCount($memberSignCollect->getCount() + 1);
        if (!$memberSignCollect->save()) {
            $this->db->rollback();
            return false;
        }
        $weekFlag = false;
        if ($memberSignCollect->getWeekCount() == 7) {
            if (!service("point/manager")->create($member, MemberPoint::TYPE_SIGN_WEEK)) {
                $this->db->rollback();
                return false;
            }
            $weekFlag = true;
            $msg = '恭喜！本周满签，今日获取12积分';
        }
        $monthFlag = false;
        if ($memberSignCollect->getMonthCount() == date('t')) {
            if (!service("point/manager")->create($member, MemberPoint::TYPE_SIGN_MONTH)) {
                $this->db->rollback();
                return false;
            }
            $monthFlag = true;
            $msg = '恭喜！本月满签，今日获取22积分';
        }
        //如果今天既是本周最后一天，也是本月最后一天，且全部满签，则今日获取积分32积分
        if ($weekFlag && $monthFlag) {
            $msg = '运气王！本周本月均满签，今日获取32积分';
        }
        if ($memberSignCollect->getContinueCount() % 365 == 0) {
            $member->setPrivilege(Member::IS_PRIVILEGE)->setPrivilegeTime(date('Y-m-d H:i:s', strtotime('+1 year')));
            if (!$member->save()) {
                $this->db->rollback();
                return false;
            }
            $msg = '大满贯！您已连续签到365天，将免费获取一年会员！';
        }
        return $msg;
    }
}