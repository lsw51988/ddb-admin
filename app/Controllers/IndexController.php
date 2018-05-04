<?php

namespace Ddb\Controllers;

use Ddb\Core\BaseController;

class IndexController extends BaseController
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        /*$smsCode = SmsCode::findFirst();
        service("sms/manager")->send($smsCode);*/
    }

    public function route404Action()
    {

    }

}