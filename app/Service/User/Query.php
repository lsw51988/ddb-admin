<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-18
 * Time: 上午11:54
 */

namespace Ddb\Service\User;


use Ddb\Core\Service;
use Ddb\Models\Users;

class Query extends Service
{
    public function getCurrentUser(){
        $user = unserialize($this->session->get("user_auth_identity"));
        return Users::findFirst($user['id']);
    }

}