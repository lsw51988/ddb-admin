<?php

namespace Ddb\Controllers;

use Ddb\Core\BaseController;
use Ddb\Models\MemberBikeImages;

class IndexController extends BaseController
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        echo "欢迎来到电动帮";
    }

    public function route404Action()
    {

    }
}