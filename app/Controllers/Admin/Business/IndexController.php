<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-15
 * Time: 上午9:20
 */

namespace Ddb\Controllers\Admin\Business;


use Ddb\Core\ViewBaseController;

/**
 * Class IndexController
 * 后台
 * @RoutePrefix("/admin/business")
 */
class IndexController extends ViewBaseController
{
    /**
     * @Get("/index")
     * 后台首页,数据统计等一些重要信息的显示,这里需要判断用户是否登录
     */
    public function indexAction(){
        $this->view->setVars([
            "content"=>"这里是后台首页",
        ]);
    }

    /**
     * @Route("/login")
     * 登录,这里注意只有限制IP才可以登录
     */
    public function loginAction(){

    }


}