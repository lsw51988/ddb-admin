<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-29
 * Time: 下午3:06
 */

namespace Ddb\Modules;


use Ddb\Models\Suggestions;

class Suggestion extends Suggestions
{
    const STATUS_CREATE = 1;
    const STATUS_REFUSE = 2;
    const STATUS_ACCEPT = 3;
}