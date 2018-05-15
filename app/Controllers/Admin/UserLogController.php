<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-15
 * Time: 下午4:19
 */

namespace Ddb\Controllers\Admin;

use Ddb\Controllers\AdminAuthController;
/**
 * Class UserLogController
 * @RoutePrefix("/admin/user_log")
 */
class UserLogController extends AdminAuthController
{

    /**
     * @Get("/{id:[0-9]+}")
     */
    public function showAction(){

    }

    /**
     * @Get("/list")
     */
    public function listAction(){

    }
}