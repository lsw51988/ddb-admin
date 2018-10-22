<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-15
 * Time: 下午4:19
 */

namespace Ddb\Controllers\Admin\Business;

use Ddb\Controllers\AdminAuthController;
use Ddb\Modules\Member;
use Ddb\Modules\MemberPoint;
use Ddb\Modules\NewBike;

/**
 * Class NBController
 * @RoutePrefix("/admin/business/nb")
 */
class NbController extends AdminAuthController
{
    /**
     * @Get("/audit")
     * 审核
     */
    public function auditAction()
    {
        $request = $this->data;
        if ($newBike = NewBike::findFirst($request['nb_id'])) {
            if ($request['type'] == 'pass') {
                $status = NewBike::STATUS_AUTH;
                //弥补审核的时间差
                $memberPoint = MemberPoint::findFirst('new_bike_id = '.$request['nb_id'].' AND type = '.MemberPoint::TYPE_PUBLISH_NB.' ORDER BY id DESC');
                $point = $memberPoint->getValue();


                $newBike->setAvailTime($realAvailTime);
            } else {
                $status = NewBike::STATUS_DENIED;
                $newBike->setCancelReason($request['reason'])
                    ->setCancelTime(date('Y-m-d H:i:s'));
            }
            if ($newBike->setStatus($status)->save()) {
                //取消扣除积分
                $member = Member::findFirst($newBike->getMemberId());
                if (!service("nb/manager")->returnPoints($member, $newBike)) {
                    return $this->error("积分扣除失败");
                }
                return $this->success();
            }
        }
        return $this->error("未找到该记录");
    }

    /**
     * @Delete("/{id:[0-9]+}")
     */
    public function deleteAction($id)
    {

    }

    /**
     * @Post("/update")
     */
    public function editAction()
    {
        $request = $this->data;
        if ($NewBike = NewBike::findFirst($request['bike_id'])) {
            if ($NewBike->setOutPrice($request['out_price'])->save()) {
                return $this->success();
            }
        }
        return $this->error("未找到该记录");
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
        $request['real_name'] = empty($request['real_name']) ? $request['real_name'] : "";
        $request['mobile'] = empty($request['mobile']) ? $request['mobile'] : "";
        $data = $this->getList($request);
        $this->view->setVars([
            'page' => $this->page,
            'data' => $data->items->toArray(),
            'total' => $data->total_items,
            'search' => $request,
            'statusDesc' => NewBike::$statusDesc
        ]);
    }

    /**
     * @Get("/to_auth")
     */
    public function toAuthAction()
    {
        $request = $this->request->get();
        $request['status'] = NewBike::STATUS_CREATE;
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
        $request['status'] = NewBike::STATUS_AUTH;
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
        $request['status'] = NewBike::STATUS_DEAL;
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

    private function getList($request)
    {
        $request['limit'] = $this->limit;
        $request['page'] = $this->page;
        $data = service("nb/query")->getAdminList($request);
        return $data;
    }
}