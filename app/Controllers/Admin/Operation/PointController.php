<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-15
 * Time: 下午4:12
 */

namespace Ddb\Controllers\Admin\Operation;

use Ddb\Controllers\AdminAuthController;

/**
 * Class PointController
 * @RoutePrefix("/admin/operation/point")
 */
class PointController extends AdminAuthController
{
    /**
     * @Get("/")
     */
    public function indexAction()
    {
        $request = $this->data;
        set_default_values($request, ['real_name', 'mobile', 'province', 'city', 'district', 'time_range']);
        $request['real_name'] = empty($request['real_name']) ? $request['real_name'] : "";
        $request['mobile'] = empty($request['mobile']) ? $request['mobile'] : "";
        if (ok($request, 'time_range')) {
            $request['start_time'] = substr($request['time_range'], 0, 10);
            $request['end_time'] = substr($request['time_range'], 13, 10);
        }
        $data = $this->getList($request);
        $this->view->setVars([
            'page' => $this->page,
            'data' => $data->items->toArray(),
            'total' => $data->total_items,
            'search' => $request,
        ]);
    }

    private function getList($request)
    {
        $request['limit'] = $this->limit;
        $request['page'] = $this->page;
        $data = service("order/query")->getList($request);
        return $data;
    }
}