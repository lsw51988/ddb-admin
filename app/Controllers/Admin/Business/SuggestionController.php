<?php
/**
 * Created by PhpStorm.
 * User: 阿德
 * Date: 2019/3/1
 * Time: 21:31
 */

namespace Ddb\Controllers\Admin\Business;


use Ddb\Controllers\AdminAuthController;
use Ddb\Modules\Member;
use Ddb\Modules\MemberPoint;
use Ddb\Modules\Suggestion;

/**
 * Class SuggestionController
 * @RoutePrefix("/admin/business/suggestion")
 */
class SuggestionController extends AdminAuthController
{
    /**
     * @Get("/list")
     */
    public function indexAction()
    {
        $request = $this->data;
        $data = $this->getList($request);
        $this->view->setVars([
            'page' => $this->page,
            'data' => $data->items->toArray(),
            'total' => $data->total_items,
            'search' => $request,
            'typeDesc' => Suggestion::$typeDesc,
            'statusDesc' => Suggestion::$statusDesc
        ]);
    }

    /**
     * @Get("/to_auth")
     */
    public function toAuthAction()
    {
        $request = $this->request->get();
        $request['status'] = Suggestion::STATUS_CREATE;
        $data = $this->getList($request);
        $this->view->setVars([
            'page' => $this->page,
            'data' => $data->items->toArray(),
            'total' => $data->total_items,
            'search' => $request,
            'typeDesc' => Suggestion::$typeDesc
        ]);
    }

    /**
     * @Post("/audit")
     * 审核
     */
    public function auditAction()
    {
        $request = $this->data;
        if ($suggestion = Suggestion::findFirst($request['suggestion_id'])) {
            if ($request['type'] == 'pass') {
                $status = Suggestion::STATUS_ACCEPT;
                $message = '建议审核通过,获得' . MemberPoint::$typeScore[MemberPoint::TYPE_SUGGESTION_APPROVED] . '积分';
            } else {
                if ($suggestion->getStatus() == Suggestion::STATUS_REFUSE) {
                    return $this->error('无法重复拒绝');
                }
                $status = Suggestion::STATUS_REFUSE;
                $suggestion->setRefuseReason($request['reason']);
                $message = '建议审核拒绝，原因：' . $request['reason'];
            }
            $this->db->begin();
            if (!$suggestion->setStatus($status)->setUpdatedAt(date('Y-m-d H:i;s'))->save()) {
                //退回用户积分
                $this->db->rollback();
                return $this->error('状态更新失败');
            }
            if ($request['type'] == 'pass') {
                $member = Member::findFirst($suggestion->getMemberId());
                if (!service("point/manager")->create($member, MemberPoint::TYPE_SUGGESTION_APPROVED)) {
                    $this->db->rollback();
                    return false;
                }
            }
            if (!service('member/manager')->saveMessage($suggestion->getMemberId(), $message)) {
                $this->db->rollback();
                return $this->error('消息未发送成功');
            }
            $this->db->commit();
            return $this->success();
        }
        return $this->error("未找到该记录");
    }

    private function getList($request)
    {
        $request['limit'] = $this->limit;
        $request['page'] = $this->page;
        $data = service("suggestion/query")->getAdminList($request);
        return $data;
    }
}