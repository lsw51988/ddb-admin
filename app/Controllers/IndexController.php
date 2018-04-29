<?php

namespace Ddb\Controllers;

use Ddb\Core\BaseController;
use Ddb\Models\MemberLogs;
use Ddb\Modules\MemberLog;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class IndexController extends BaseController
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        print_r(di('config')->get("queue")->toArray());
    }

    public function route404Action()
    {

    }

}