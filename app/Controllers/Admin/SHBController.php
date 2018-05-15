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
 * Class SHBController
 * @RoutePrefix("/admin/shb")
 */
class SHBController extends AdminAuthController
{
    /**
     * @Post("/audit/{id:[0-9]+}")
     * 审核
     */
    public function auditAction(){

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