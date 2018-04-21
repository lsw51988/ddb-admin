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
        echo "欢饮来到我的帝国";
    }

    public function route404Action()
    {

    }
}