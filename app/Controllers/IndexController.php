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
       /* phpinfo();
        exit();*/
        //service("sms/manager")->send(1);
        $a = service("queue/manager")->queue("Testa",['cmd' => 'approve', 'aa' => "aaa","bbb"=>"ccc"]);
        print_r($a);
    }

    public function route404Action()
    {

    }

}