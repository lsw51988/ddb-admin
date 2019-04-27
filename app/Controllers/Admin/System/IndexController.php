<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-16
 * Time: 上午11:02
 */

namespace Ddb\Controllers\Admin\System;


use Ddb\Controllers\AdminAuthController;

/**
 * Class IndexController
 * @package Ddb\Controllers\Admin\System
 * @RoutePrefix("/admin/system/index")
 */
class IndexController extends AdminAuthController
{
    /**
     * @Get("/")
     */
    public function indexAction(){
        $this->view->setVars([
            "content"=>"system-index",
        ]);
    }

}