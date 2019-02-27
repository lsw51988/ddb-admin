<?php

namespace Ddb\Controllers;

use Ddb\Core\BaseController;
use Ddb\Models\MemberBikeImages;
use Ddb\Modules\Member;
use Ddb\Modules\MemberMessage;

class IndexController extends BaseController
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        echo "欢迎来到电动帮";
    }

    /**
     * @Route("/test")
     */
    public function testAction(){

    }

    public function route404Action()
    {

    }
}