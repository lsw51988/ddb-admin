<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-15
 * Time: 下午4:12
 */

namespace Ddb\Controllers\Admin\System;

use Ddb\Controllers\AdminAuthController;
/**
 * Class UserController
 * @RoutePrefix("/admin/system/user")
 */
class UserController extends AdminAuthController
{
    /**
     * @Post("/")
     */
    public function createAction(){

    }

    /**
     * @Delete("/{id:[0-9]+}")
     */
    public function deleteAction($id){

    }

    /**
     * @Put("/{id:[0-9]+}")
     */
    public function editAction(){

    }

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