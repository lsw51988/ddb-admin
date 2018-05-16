<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-16
 * Time: 下午11:47
 */

namespace Ddb\Servive\SHB;


use Ddb\Core\Service;
use Ddb\Modules\MemberPoint;

class Query extends Service
{
    public function hasEnoughPoint($member)
    {
        if ($member->getPoint() < MemberPoint::$typeScore[MemberPoint::TYPE_PUBLISH_SHB]) {
            return false;
        }
        return true;
    }
}