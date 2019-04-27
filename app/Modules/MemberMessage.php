<?php
/**
 * Created by PhpStorm.
 * User: 阿德
 * Date: 2019/1/28
 * Time: 22:16
 */

namespace Ddb\Modules;


use Ddb\Models\MemberMessages;

class MemberMessage extends MemberMessages
{
    //状态 1创建 2已读
    const STATUS_CREATE = 1;
    const STATUS_READ = 2;
}