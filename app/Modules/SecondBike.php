<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-6-5
 * Time: 下午2:48
 */

namespace Ddb\Modules;


use Ddb\Models\SecondBikes;

class SecondBike extends SecondBikes
{
    const STATUS_CREATE = 1;
    const STATUS_CANCEL = 2;
    const STATUS_DEAL = 3;
    const STATUS_ABNORMAL = 4;
}