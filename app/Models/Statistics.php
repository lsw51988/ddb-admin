<?php
/**
 * Created by PhpStorm.
 * User: zl
 * Date: 2016/9/19
 * Time: 18:46
 */

namespace Dowedo\Models;

use Dowedo\Modules\Member\Models\Member;

class Statistics
{
    public function getData()
    {
        return array(
            'memberCount' => $this->getMemberCount()
        );
    }

    public function getMemberCount()
    {
        $count = Member::count();
        return $count;
    }
}