<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 19-1-14
 * Time: 下午3:36
 */

namespace Ddb\Modules;


use Ddb\Models\LostBikes;

class LostBike extends LostBikes
{
    const STATUS_CREATE = 0;
    const STATUS_PASS = 1;
    const STATUS_REFUSE = 2;
    const STATUS_FIND = 3;
    const STATUS_NOT_FIND = 4;

    static $statusDesc = ['刚创建', '审核通过', '审核拒绝', '成功找到', '未找到'];
}