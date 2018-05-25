<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-17
 * Time: 下午3:46
 */

namespace Ddb\Controllers\Admin;


use Ddb\Core\ViewBaseController;

/**
 * Class IndexController
 * @RoutePrefix("/admin")
 */
class IndexController extends ViewBaseController
{
    /**
     * @Route("/login")
     */
    public function loginAction()
    {
        if ($this->request->isPost()) {
            $data = $this->data;
            if ($user = service("user/manager")->verify($data)) {
                if(service("user/manager")->login($user)){
                    return $this->response->redirect('/admin/business/index');
                }else{
                    return $this->error("登录失败");
                }

            }else{
                return $this->error("用户不存在或密码错误");
            }
        }
    }
}