<?php
/**
 * Created by PhpStorm.
 * User: 阿德
 * Date: 2019/3/4
 * Time: 23:38
 */

namespace Ddb\Controllers\Admin\Business;


use Ddb\Controllers\AdminAuthController;
use Ddb\Models\RepairAuthImages;
use Ddb\Models\RepairImages;
use Ddb\Modules\Member;
use Ddb\Modules\Repair;
use Ddb\Modules\RepairClaim;

/**
 * Class RepairClaimController
 * @package Ddb\Controllers\Admin\Business
 * @RoutePrefix("/admin/business/repairClaim")
 */
class RepairClaimController extends AdminAuthController
{
    /**
     * @Get("/list")
     */
    public function listAction()
    {
        $request = $this->request->get();
        $request['limit'] = $this->limit;
        $request['page'] = $this->page;
        set_default_values($request, ['status', 'province', 'city', 'district']);
        $data = service("repairClaim/query")->getList($request);
        $this->view->setVars([
            'page' => $this->page,
            'data' => $data->items->toArray(),
            'total' => $data->total_items,
            'search' => $request
        ]);
    }

    /**
     * @Get("/to_auth")
     */
    public function toAuthAction()
    {
        $request = $this->request->get();
        $request['limit'] = $this->limit;
        $request['page'] = $this->page;
        set_default_values($request, ['province', 'city', 'district']);
        $request['status'] = RepairClaim::STATUS_CREATE;
        $data = service("repairClaim/query")->getList($request);
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
    public function imgsAction($repairClaimId)
    {
        $repairId = RepairClaim::findFirst($repairClaimId)->getRepairId();
        $repairImgs = RepairImages::findByRepairId($repairId);
        $data = [];
        if (count($repairImgs->toArray()) > 0) {
            $repairImgsIds = array_column($repairImgs->toArray(), 'id');
            foreach ($repairImgsIds as $id) {
                $data[] = "/wechat/repair/repairImg/" . $id;
            }
        }

        $repairAuthImages = RepairAuthImages::findByRepairId($repairClaimId);
        if (count($repairAuthImages->toArray()) > 0) {
            $repairAuthImagesIds = array_column($repairAuthImages->toArray(), 'id');
            foreach ($repairAuthImagesIds as $id) {
                $data[] = "/wechat/repair/repairClaimImg/" . $id;
            }
        }

        return $this->success($data);
    }

    /**
     * @Post("/auth")
     * 审核
     */
    public function authAction()
    {
        $request = $this->data;
        if ($repairClaim = RepairClaim::findFirst($request['repair_claim_id'])) {
            if ($request['type'] == 'pass') {
                $status = RepairClaim::STATUS_PASS;
                $message = '维修点申领审核通过';
            } else {
                $status = RepairClaim::STATUS_REFUSE;
                $message = '维修点申领审核拒绝,原因：' . $request['reason'];
            }
            $this->db->begin();
            if (!service('member/manager')->saveMessage($repairClaim->getMemberId(), $message)) {
                $this->db->rollback();
                return $this->error('消息未发送成功');
            }
            if (!$repairClaim->setStatus($status)->save()) {
                $this->db->rollback();
                return $this->error('状态变更失败');
            }
            if ($request['type'] == 'pass') {
                $member = Member::findFirst($repairClaim->getMemberId());
                if (!$member->setMobile($repairClaim->getMobile())->save()) {
                    $this->db->rollback();
                    return $this->error('更改用户手机失败');
                }
                $repair = Repair::findFirst($repairClaim->getRepairId());
                $repair->setBelongerName($repairClaim['name'])
                    ->setMobile($repairClaim['mobile'])
                    ->setBelongerId($repairClaim->getMemberId())
                    ->setAuditorId($this->currentUser->getId())
                    ->setUpdatedAt(date('Y-m-d H:i;s'));
                if (!$repair->save()) {
                    $this->db->rollback();
                    return $this->error('归属者信息更改失败');
                }
            }

            $this->db->commit();
            return $this->success();
        }
        return $this->error();
    }
}