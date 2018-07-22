<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-15
 * Time: 下午4:19
 */

namespace Ddb\Controllers\Admin\Business;

use Ddb\Controllers\AdminAuthController;
use Ddb\Modules\SecondBike;

/**
 * Class SHBController
 * @RoutePrefix("/admin/business/shb")
 */
class ShbController extends AdminAuthController
{
    /**
     * @Post("/audit/{id:[0-9]+}")
     * 审核
     */
    public function auditAction()
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
        $request = $this->request->get();
        $request['status'] = SecondBike::STATUS_CREATE;
        $request['real_name'] = empty($request['real_name']) ? $request['real_name'] : "";
        $request['mobile'] = empty($request['mobile']) ? $request['mobile'] : "";
        $data = $this->getList($request);
        $this->view->setVars([
            'page' => $this->page,
            'data' => $data->items->toArray(),
            'total' => $data->total_items,
            'search' => $request,
            'statusDesc' => SecondBike::$statusDesc
        ]);
    }

    /**
     * @Get("/to_auth")
     */
    public function toAuthAction()
    {
        $request = $this->request->get();
        $request['status'] = SecondBike::STATUS_CREATE;
        $request['real_name'] = empty($request['real_name']) ? $request['real_name'] : "";
        $request['mobile'] = empty($request['mobile']) ? $request['mobile'] : "";
        $data = $this->getList($request);
        $this->view->setVars([
            'page' => $this->page,
            'data' => $data->items->toArray(),
            'total' => $data->total_items,
            'search' => $request
        ]);
    }

    /**
     * @Get("/trading")
     */
    public function tradingAction()
    {
        $request = $this->request->get();
        $request['status'] = SecondBike::STATUS_AUTH;
        $request['real_name'] = empty($request['real_name']) ? $request['real_name'] : "";
        $request['mobile'] = empty($request['mobile']) ? $request['mobile'] : "";
        $data = $this->getList($request);
        $this->view->setVars([
            'page' => $this->page,
            'data' => $data->items->toArray(),
            'total' => $data->total_items,
            'search' => $request
        ]);
    }

    /**
     * @Get("/traded")
     */
    public function tradedAction()
    {
        $request = $this->request->get();
        $request['status'] = SecondBike::STATUS_DEAL;
        $request['real_name'] = empty($request['real_name']) ? $request['real_name'] : "";
        $request['mobile'] = empty($request['mobile']) ? $request['mobile'] : "";
        $data = $this->getList($request);
        $this->view->setVars([
            'page' => $this->page,
            'data' => $data->items->toArray(),
            'total' => $data->total_items,
            'search' => $request
        ]);
    }

    private function getList($request){
        $request['limit'] = $this->limit;
        $request['page'] = $this->page;
        $request['status'] = SecondBike::STATUS_CREATE;
        $data = service("shb/query")->getAdminList($request);
        return $data;
    }
}