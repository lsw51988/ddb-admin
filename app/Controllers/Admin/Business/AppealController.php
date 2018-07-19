<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-15
 * Time: 上午9:20
 */

namespace Ddb\Controllers\Admin\Business;


use Ddb\Controllers\AdminAuthController;
use Ddb\Modules\Appeal;

/**
 * Class AppealController
 * @RoutePrefix("/admin/business/appeal")
 */
class AppealController extends AdminAuthController
{
    /**
     * @Get("/list")
     * 获取求助总览页面
     */
    public function listAction()
    {
        $request = $this->request->get();
        $data = service("appeal/query")->getList($request);
        $this->view->setVars([
            'page' => $this->page,
            'data' => $data->items->toArray(),
            'total' => $data->total_items,
            'type_desc'=>Appeal::$typeDesc,
            'status_desc'=>Appeal::$statusDesc,
            'search' => $request
        ]);
    }
}