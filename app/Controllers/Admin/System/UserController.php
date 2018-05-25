<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-15
 * Time: 下午4:12
 */

namespace Ddb\Controllers\Admin\System;

use Ddb\Controllers\AdminAuthController;
use Ddb\Core\ViewBaseController;
use Ddb\Modules\User;

/**
 * Class UserController
 * @RoutePrefix("/admin/system/user")
 */
class UserController extends ViewBaseController
{
    /**
     * @Post("/")
     */
    public function createAction()
    {

    }

    /**
     * @Delete("/{id:[0-9]+}")
     */
    public function deleteAction($id)
    {

    }

    /**
     * @Put("/{id:[0-9]+}")
     */
    public function editAction()
    {

    }

    /**
     * @Get("/{id:[0-9]+}")
     */
    public function showAction()
    {

    }

    /**
     * @Get("/list")
     */
    public function listAction()
    {
        $data = $this->data;
        $columns = ["id", "name", "mobile", "status", "email", "login_ip"];
        $page = $this->page;
        $order = "created_at DESC";

        $data = User::page($columns, "", [], "", $page, "");
        $this->view->setVars([
            "data" => $data
        ]);
    }
}