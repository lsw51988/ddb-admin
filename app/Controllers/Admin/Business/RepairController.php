<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-15
 * Time: 上午9:20
 */

namespace Ddb\Controllers\Admin\Business;

use Ddb\Controllers\AdminAuthController;
use Ddb\Models\RepairImages;
use Ddb\Modules\Repair;

/**
 * Class RepairController
 * 维修点
 * @RoutePrefix("/admin/business/repair")
 */
class RepairController extends AdminAuthController
{
    /**
     * @Get("/{id:[0-9+]}")
     */
    public function indexAction($id)
    {

    }

    /**
     * @Put("/{id:[0-9+]}")
     */
    public function editAction($id)
    {

    }

    /**
     * @Delete("/{id:[0-9+]}")
     */
    public function delAction($id)
    {

    }

    /**
     * @Get("/list")
     */
    public function listAction()
    {
        $request = $this->request->get();
        $request['limit'] = $this->limit;
        $request['page'] = $this->page;
        set_default_values($request, ['name', 'mobile', 'province', 'city', 'district']);
        $request['status'] = isset($request['status']) ? $request['status'] : 99;
        $request['type'] = isset($request['type']) ? $request['type'] : 99;
        $data = service("repair/query")->getList($request);
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
    public function imgsAction($repairId)
    {
        $repairImages = RepairImages::findFirstByRepairId($repairId);
        if (count($repairImages->toArray()) == 0) {
            return $this->error('暂无照片');
        }
        $ids = array_column($repairImages->toArray(), 'id');
        $data = [];
        foreach ($ids as $id) {
            $data[] = "/wechat/repair/repairImg/" . $id;
        }
        return $this->success($data);
    }

    /**
     * @Post("/audit/{id:[0-9+]}")
     * 审核
     */
    public function authAction($id)
    {

    }

    /**
     * @Post("")
     * 修改维修点的信息
     */
    public function updateAction()
    {
        $request = $this->request->get();
        if ($repair = Repair::findFirst($request['repair_id'])) {
            if ($repair->setName($request['name'])->setMobile($request['mobile'])->save()) {
                return $this->success();
            }
        }
        return $this->error("没有此维修点数据");
    }

}