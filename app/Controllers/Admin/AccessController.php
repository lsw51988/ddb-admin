<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-15
 * Time: 下午4:12
 */

namespace Ddb\Controllers\Admin;

use Ddb\Controllers\AdminAuthController;

/**
 * Class AccessController
 * @RoutePrefix("/admin/access")
 */
class AccessController extends AdminAuthController
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
    public function editAction($id){

    }

    /**
     * @Get("/list")
     */
    public function listAction(){

    }

}