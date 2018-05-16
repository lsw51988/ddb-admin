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
 * Class MemberLogController
 * @RoutePrefix("/admin/system/member_log")
 */
class MemberLogController extends AdminAuthController
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