<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-18
 * Time: 下午12:00
 */

namespace Ddb\Modules;


use Ddb\Models\Users;

class User extends Users
{
    const STATUS_FORBIDDEN = 0;
    const STATUS_NORMAL = 1;
}