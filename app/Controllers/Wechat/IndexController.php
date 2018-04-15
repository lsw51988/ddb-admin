<?php
/**
 * Created by PhpStorm.
 * User: 阿德
 * Date: 2018/4/15
 * Time: 17:40
 */

namespace Ddb\Controllers\Wechat;


class IndexController
{
    /**
     * @Get("/wechat/index")
     */
    public function indexAction(){
        echo "wechat-index";
    }
}