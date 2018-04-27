<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-27
 * Time: 下午8:56
 */

namespace Ddb\Modules;


use Ddb\Models\MemberLogs;

class MemberLog extends MemberLogs
{
    //0普通用户可见 1后台人员可见
    const TYPE_VISIBLE = 0;
    const TYPE_ADMIN = 1;
}