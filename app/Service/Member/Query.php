<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-24
 * Time: 下午11:20
 */

namespace Ddb\Service\Member;


use Ddb\Models\MemberPoints;
use Ddb\Models\Members;
use Ddb\Service\BaseService;

class Query extends BaseService
{
    /**
     * @param $point
     * @return string
     * 根据总积分,包括已经消耗的
     */
    public function getLevel($point)
    {
        switch ($point) {
            case $point <= 500:
                return "铜牌会员";
                break;
            case $point <= 1000 && $point > 500:
                return "银牌会员";
                break;
            case $point <= 2000 && $point > 1000:
                return "金牌会员";
                break;
            case $point <= 5000 && $point > 2000:
                return "钻石会员";
                break;
            case $point > 5000:
                return "至尊宝";
                break;
        }
    }

    /**
     * 获取用户获取的总积分
     */
    public function getTotalPoints(Members $member)
    {
        $totalPoints = MemberPoints::sum([
            "column" => "value",
            "conditions" => "member_id = :member_id: AND type>0",
            "bind" => [
                "member_id" => $member->getId()
            ]
        ]);
        return is_null($totalPoints) ? 0 : $totalPoints;
    }
}