<?php
/**
 * Created by PhpStorm.
 * User: 阿德
 * Date: 2019/3/4
 * Time: 23:12
 */

namespace Ddb\Modules;


use Ddb\Models\RepairClaims;

class RepairClaim extends RepairClaims
{
    //状态 1-创建 2-通过 3-拒绝
    const STATUS_CREATE = 1;
    const STATUS_PASS = 2;
    const STATUS_REFUSE = 3;
}