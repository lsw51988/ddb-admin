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

    public function afterUpdate()
    {
        $token = $this->getToken();
        app_log()->info("触发afterUpdate事件" . $this->getToken());
        $member = $this->findFirstByToken($token);
        app_log()->info("写入token缓存:");
        di("cache")->save($this->getToken(), serialize($member), 24 * 3600 * 30);
    }
}