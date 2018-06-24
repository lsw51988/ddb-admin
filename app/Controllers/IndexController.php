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

    /**
     * @Get("/ali")
     */
    public function aliAction(){
        $arr = [
            [
                "value"=>strval(random_int(300,400)),
                "lng"=>"116.366",
                "lat"=>"39.8673"
            ],
            [
                "value"=>strval(random_int(300,400)),
                "lng"=>"116.376",
                "lat"=>"39.8673"
            ],
            [
                "value"=>strval(random_int(300,400)),
                "lng"=>"116.356",
                "lat"=>"39.8673"
            ],
            [
                "value"=>strval(random_int(300,400)),
                "lng"=>"116.366",
                "lat"=>"39.8573"
            ],
            [
                "value"=>strval(random_int(300,400)),
                "lng"=>"116.366",
                "lat"=>"39.8773"
            ],
            [
                "value"=>strval(random_int(300,400)),
                "lng"=>"116.366",
                "lat"=>"39.8503"
            ]
        ];
        return json_encode($arr);
    }

    public function route404Action()
    {

    }
}