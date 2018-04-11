<?php
namespace Ddb\Controllers;

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {

        echo "ddb";
    }

    /**
     * @Route("/ddb")
     */
    public function ddbAction()
    {

        echo "ddb-test";
    }

    public function route404Action()
    {

    }
}