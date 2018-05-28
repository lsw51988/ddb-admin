<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-4
 * Time: 下午9:34
 */

namespace Ddb\Service\Point;

use Ddb\Modules\Member;
use Ddb\Modules\MemberPoint;
use Ddb\Service\BaseService;

class Manager extends BaseService
{
    /**
     * @param Member $member
     * @param $type
     * @param null $second_bike_id
     * @param null $appeal_id
     * @return bool
     */
    public function create(Member $member, $type, $second_bike_id = null, $appeal_id = null)
    {
        $memberPoint = new MemberPoint();
        $point = MemberPoint::$typeScore[$type];
        $memberPoint->setMemberId($member->getId())
            ->setType($type)
            ->setValue($point);
        if ($second_bike_id) {
            $memberPoint->setSecondBikeId($second_bike_id);
        }
        if ($appeal_id) {
            $memberPoint->setAppealId($appeal_id);
        }
        if (!$memberPoint->save()) {
            return false;
        }
        $currentPoint = (int)$member->getPoints();
        $endPoint = $currentPoint + $point;
        if ($endPoint < 0) {
            return false;
        }
        if (!$member->setPoints($endPoint)->save()) {
            $memberPoint->delete();
            return false;
        }
        return true;
    }
}