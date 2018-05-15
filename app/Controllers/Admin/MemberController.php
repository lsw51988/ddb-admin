<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-15
 * Time: 下午4:24
 */

namespace Ddb\Controllers\Admin;

use Ddb\Controllers\AdminAuthController;

/**
 * Class RoleController
 * @RoutePrefix("/admin/member")
 */
class MemberController extends AdminAuthController
{
    /**
     * @Get("/{id:[0-9]+}")
     */
    public function showAction($id){

    }

    /**
     * @Get("/list")
     */
    public function listAction(){

    }

    /**
     * @Post("/auth/{id:[0-9]+}")
     * 审核用户资料
     */
    public function authAction($id){

    }

    /**
     * @Put("/{id:[0-9]+}")
     */
    public function editAction(){

    }

}