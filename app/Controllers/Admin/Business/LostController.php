<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-15
 * Time: 下午4:19
 */

namespace Ddb\Controllers\Admin\Business;

use Ddb\Controllers\AdminAuthController;
use Ddb\Models\MemberBikeImages;
use Ddb\Modules\LostBike;

/**
 * Class LostController
 * @RoutePrefix("/admin/business/lost")
 */
class LostController extends AdminAuthController
{
    /**
     * @Get("/list")
     */
    public function listAction()
    {
        $request = $this->data;
        set_default_values($request, ['real_name', 'mobile', 'status']);
        $data = $this->getList($request);
        $this->view->setVars([
            'page' => $this->page,
            'data' => $data->items->toArray(),
            'total' => $data->total_items,
            'search' => $request,
            'statusDesc' => LostBike::$statusDesc
        ]);
    }

    /**
     * @Get("/to_auth")
     */
    public function toAuthAction()
    {
        $request = $this->request->get();
        set_default_values($request, ['real_name', 'mobile']);
        $request['status'] = LostBike::STATUS_CREATE;
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
        $memberBikeImgs = MemberBikeImages::findByMemberBikeId($bikeId);
        $ids = array_column($memberBikeImgs->toArray(), 'id');
        $data = [];
        foreach ($ids as $id) {
            $data[] = "/wechat/member/bikeImg/" . $id;
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
        if ($lostBike = LostBike::findFirst($request['bike_id'])) {
            if ($lostBike->getStatus() == LostBike::STATUS_REFUSE) {
                return $this->error('无法重复拒绝');
            }
            if (service('lost/manager')->auth($lostBike, $request)) {
                return $this->success();
            }else{
                return $this->error('更新数据失败');
            }
        }
        return $this->error("未找到该记录");
    }

    private function getList($request)
    {
        $request['limit'] = $this->limit;
        $request['page'] = $this->page;
        $data = service("lost/query")->getAdminList($request);
        return $data;
    }
}