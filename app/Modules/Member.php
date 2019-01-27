<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-24
 * Time: 下午11:58
 */

namespace Ddb\Modules;


use Ddb\Models\Members;

class Member extends Members
{
    const TYPE_RIDE = 1;//骑行者
    const TYPE_FIX = 2;//修理者

    const STATUS_TO_AUTH = 1;
    const STATUS_AUTHED = 2;
    const STATUS_AUTH_DENIED = 3;

    const IS_NOT_PRIVILEGE = 0;
    const IS_PRIVILEGE = 1;
}