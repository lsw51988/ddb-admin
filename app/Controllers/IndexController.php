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
        echo di("config")->app->URL;
    }

    public function route404Action()
    {

    }
}