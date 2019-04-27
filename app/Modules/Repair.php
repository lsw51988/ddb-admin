<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-14
 * Time: 下午8:18
 */

namespace Ddb\Modules;

use Ddb\Models\Repairs;

class Repair extends Repairs
{
    const TYPE_REPAIR = 0;
    const TYPE_REPAIR_AND_SELL = 1;
    const TYPE_LOCK = 2;

    public static $typeDesc = [
        self::TYPE_REPAIR=>"电动车维修点",
        self::TYPE_REPAIR_AND_SELL=>"电动车维修兼销售点",
        self::TYPE_LOCK=>"便民开锁点"
    ];

    /**
     * status
     * 1被创建 2后台审核通过 3后台审核拒绝
     */
    const STATUS_CREATE = 1;
    const STATUS_PASS = 2;
    const STATUS_REFUSE = 3;

    public static $statusDesc = [
        self::STATUS_CREATE=>"被创建",
        self::STATUS_PASS=>"后台审核通过",
        self::STATUS_REFUSE=>"后台审核拒绝"
    ];
}