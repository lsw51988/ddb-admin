<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-15
 * Time: 下午4:19
 */

namespace Ddb\Controllers\Admin\System;

use Ddb\Controllers\AdminAuthController;
/**
 * Class RoleController
 * @RoutePrefix("/admin/system/access")
 */
class RoleController extends AdminAuthController
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