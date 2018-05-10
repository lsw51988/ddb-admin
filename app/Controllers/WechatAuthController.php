<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-23
 * Time: 下午2:31
 */

namespace Ddb\Controllers;


use Ddb\Core\BaseController;

class WechatAuthController extends BaseController
{
    protected $token = "";
    protected $currentMember = "";

    public function onConstruct()
    {
        parent::onConstruct();
        $token = $this->request->getHeader("token");
        if ($token == "") {
            return $this->error("请重新登录");
        } else {
            $this->token = $token;
            //用户更新信息时,需求重新写入缓存
            $this->currentMember = unserialize(di("cache")->get($token));
        }

    }
}