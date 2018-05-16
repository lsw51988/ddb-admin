<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-15
 * Time: 上午9:20
 */

namespace Ddb\Controllers\Admin\Business;

use Ddb\Controllers\AdminAuthController;

/**
 * Class RepairController
 * 维修点
 * @RoutePrefix("/admin/business/repair")
 */
class RepairController extends AdminAuthController
{
    /**
     * @Get("/{id:[0-9+]}")
     */
    public function indexAction($id){

    }

    /**
     * @Put("/{id:[0-9+]}")
     */
    public function editAction($id){

    }

    /**
     * @Delete("/{id:[0-9+]}")
     */
    public function delAction($id){

    }

    /**
     * @Get("/list")
     */
    public function listAction(){

    }

    /**
     * @Post("/audit/{id:[0-9+]}")
     * 审核
     */
    public function authAction($id){

    }

}