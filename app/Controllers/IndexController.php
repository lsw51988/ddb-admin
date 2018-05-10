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
        echo "welcome";
    }

    public function route404Action()
    {

    }

}