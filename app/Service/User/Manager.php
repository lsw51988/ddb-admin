<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-17
 * Time: 下午10:53
 */

namespace Ddb\Service\User;


use Ddb\Core\Service;
use Ddb\Models\Users;

class Manager extends Service
{
    private $sessionKey = "user_auth_identity";
    /**
     * @param $data
     * @return bool|\Phalcon\Mvc\Model
     */
    public function verify($data)
    {
        $user = Users::findFirst([
            "conditions" => "name = :name: OR mobile = :mobile:",
            "bind" => [
                "name" => $data['login'],
                "mobile" => $data['login']
            ]
        ]);
        if (!$user) {
            return false;
        }
        if (!$this->security->checkHash($data['mobile'], $user->getPassword())) {
            return false;
        }
        return $user;
    }

    public function login(Users $user,$lifetime=null){
        $user->setLoginIp($this->request->getClientAddress());
        if(!$user->save()){
            return false;
        }
        $session = di("session");
        $sessionName = $session->getName();
        if($lifetime){
            setcookie($sessionName,$_COOKIE[$sessionName],time()+$lifetime);
            $options = $session->getOptions();
            $options['lifetime'] = $lifetime;
            $session->setOptions($options);
        }
        $session->set($this->sessionKey, $user->serialize());
        return true;
    }
}