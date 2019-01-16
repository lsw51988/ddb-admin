<?php

namespace Ddb\Controllers;

use Ddb\Core\BaseController;
use Ddb\Models\MemberBikeImages;
use Ddb\Modules\Member;

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
        $member = Member::findFirstByToken('87101405469f326cab883b02f3690b78');
        print_r($member->toArray());
    }

    public function route404Action()
    {

    }
}