<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-15
 * Time: 上午9:20
 */

namespace Ddb\Controllers\Admin;


use Ddb\Core\ViewBaseController;

/**
 * Class IndexController
 * 后台
 * @RoutePrefix("/admin/index")
 */
class IndexController extends ViewBaseController
{
    /**
     * @Get("/")
     * 后台首页,数据统计等一些重要信息的显示,这里需要判断用户是否登录
     */
    public function indexAction(){

    }

    /**
     * @Route("/login")
     * 登录,这里注意只有限制IP才可以登录
     */
    public function loginAction(){

    }


}