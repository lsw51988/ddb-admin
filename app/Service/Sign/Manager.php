<?php
namespace Ddb\Service\Sign;

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
        //签到逻辑 本周第一天则week_count=1 本月第一天month_count=1 查看前一天是否签到如果签到，且不是周期第一天，则+1

        $yesterdayFlag = false;
        $msg = '签到成功，获取2积分';
        //每个月的第N天
        if (date('j') == 1) {
            $memberSign->setMonthCount(1);
        }
        //每周的第N天
        if (date('N') == 1) {
            $memberSign->setWeekCount(1);
        }

        if ($lastSign = MemberSigns::findFirst('member_id = ' . $member->getId() . ' order by id DESC')) {
            if ($lastSign->getDay() == date('Y-m-d')) {
                $yesterdayFlag = true;
            }
            $memberSign->setMonthCount($lastSign->getMonthCount() + 1)->setWeekCount($lastSign->getWeekCount() + 1);
        }

        if ($yesterdayFlag) {
            $memberSign->setContinueCount($memberSign->getContinueCount() + 1);
        } else {
            $memberSign->setContinueCount(1);
        }
        $memberSign->setCount($memberSign->getCount() + 1);
        if (!$memberSign->save()) {
            $this->db->rollback();
            return false;
        }
        $weekFlag = false;
        if ($memberSign->getWeekCount() == 7) {
            if (!service("point/manager")->create($member, MemberPoint::TYPE_SIGN_WEEK)) {
                $this->db->rollback();
                return false;
            }
            $weekFlag = true;
            $msg = '恭喜！本周满签，今日获取12积分';
        }
        $monthFlag = false;
        if ($memberSign->getMonthCount() == date('t')) {
            if (!service("point/manager")->create($member, MemberPoint::TYPE_SIGN_MONTH)) {
                $this->db->rollback();
                return false;
            }
            $monthFlag = true;
            $msg = '恭喜！本月满签，今日获取22积分';
        }
        //如果今天既是本周最后一天，也是本月最后一天，且全部满签，则今日获取积分32积分
        if ($weekFlag && $monthFlag) {
            $msg = '恭喜！本周本月均满签，今日获取32积分';
        }
        if ($memberSign->getContinueCount() % 365 == 0) {
            $member->setPrivilege(Member::IS_PRIVILEGE)->setPrivilegeTime(date('Y-m-d H:i:s', strtotime('+1 year')));
            if (!$member->save()) {
                $this->db->rollback();
                return false;
            }
            $msg = '大满贯！您已连续签到365天，将免费获取一年会员！';
        }
        $this->db->commit();
        return $msg;
    }
}