<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-15
 * Time: 下午4:19
 */

namespace Ddb\Controllers\Admin\Business;

use Ddb\Controllers\AdminAuthController;
use Ddb\Models\SecondBikeImages;
use Ddb\Modules\Member;
use Ddb\Modules\MemberPoint;
use Ddb\Modules\SecondBike;

/**
 * Class SHBController
 * @RoutePrefix("/admin/business/shb")
 */
class ShbController extends AdminAuthController
{
    /**
     * @Get("/list")
     */
    public function listAction()
    {
        $request = $this->data;
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

    /**
     * @Get("/{id:[0-9]+}/imgs")
     */
    public function imgsAction($bikeId)
    {
        $memberBikeImgs = SecondBikeImages::findBySecondBikeId($bikeId);
        $ids = array_column($memberBikeImgs->toArray(), 'id');
        $data = [];
        foreach ($ids as $id) {
            $data[] = "/wechat/shb/bikeImg/" . $id;
        }
        return $this->success($data);
    }

    /**
     * @Post("/audit")
     * 审核
     */
    public function auditAction()
    {
        $request = $this->data;
        if ($secondBike = SecondBike::findFirst($request['shb_id'])) {
            if ($request['type'] == 'pass') {
                $status = SecondBike::STATUS_AUTH;
            } else {
                if ($secondBike->getStatus() == SecondBike::STATUS_DENIED) {
                    return $this->error('无法重复拒绝');
                }
                $status = SecondBike::STATUS_DENIED;
                $secondBike->setRefuseReason($request['reason']);
            }
            if ($secondBike->setStatus($status)->save()) {
                //退回用户积分
                $member = Member::findFirst($secondBike->getMemberId());
                if (!service("shb/manager")->returnPoints($member, $secondBike)) {
                    return $this->error("积分取消扣除失败");
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
        if ($secondBike = SecondBike::findFirst($request['bike_id'])) {
            if ($secondBike->setOutPrice($request['out_price'])->save()) {
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

    private function getList($request)
    {
        $request['limit'] = $this->limit;
        $request['page'] = $this->page;
        $data = service("shb/query")->getAdminList($request);
        return $data;
    }
}