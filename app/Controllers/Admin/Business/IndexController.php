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
 * Class IndexController
 * @RoutePrefix("/admin/business")
 */
class IndexController extends AdminAuthController
{
    /**
     * @Get("/index")
     * 后台首页,数据统计等一些重要信息的显示,这里需要判断用户是否登录
     */
    public function indexAction(){
        $this->view->setVars([
            "content"=>"这里是业务后台首页",
        ]);
    }
}