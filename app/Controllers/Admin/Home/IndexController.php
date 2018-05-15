<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-15
 * Time: 上午9:20
 */

namespace Ddb\Controllers\Admin\Home;


use Ddb\Core\ViewBaseController;

/**
 * Class IndexController
 * 后台
 * @RoutePrefix("/admin/home")
 */
class IndexController extends ViewBaseController
{
    /**
     * @Get("/")
     */
    public function indexAction(){
        $this->view->setVars([
            "aaa"=>"home-8888",
            "bbb"=>"bbb",
        ]);
    }

}