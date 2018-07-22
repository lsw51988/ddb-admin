<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-15
 * Time: 下午4:24
 */

namespace Ddb\Controllers\Admin\Business;

use Ddb\Controllers\AdminAuthController;
use Ddb\Modules\Member;


/**
 * Class RoleController
 * @RoutePrefix("/admin/business/member")
 */
class MemberController extends AdminAuthController
{
    /**
     * @Get("/{id:[0-9]+}")
     */
    public function showAction($id)
    {

    }

    /**
     * 列表
     * @Get("/list")
     */
    public function listAction()
    {
        $request = $this->request->get();
        $request['type'] = Member::TYPE_RIDE;
        $request['limit'] = $this->limit;
        $request['page'] = $this->page;
        $request['real_name'] = empty($request['real_name']) ? $request['real_name'] : "";
        $request['mobile'] = empty($request['mobile']) ? $request['mobile'] : "";
        $data = service("member/query")->getList($request);
        $this->view->setVars([
            'page' => $this->page,
            'data' => $data->items->toArray(),
            'total' => $data->total_items,
            'search' => $request
        ]);
    }

    /**
     * 列表
     * @Get("/to_auth")
     */
    public function toAuthAction()
    {
        $request = $this->request->get();
        $type = Member::TYPE_RIDE;
        if (!empty($request['type'])) {
            $type = $request['type'];
        }
        $request['type'] = $type;
        $request['status'] = Member::STATUS_TO_AUTH;
        $request['limit'] = $this->limit;
        $request['page'] = $this->page;
        $request['real_name'] = empty($request['real_name']) ? $request['real_name'] : "";
        $request['mobile'] = empty($request['mobile']) ? $request['mobile'] : "";
        $data = service("member/query")->getList($request);
        $this->view->setVars([
            'page' => $this->page,
            'data' => $data->items->toArray(),
            'total' => $data->total_items,
            'search' => $request
        ]);
    }

    /**
     * 列表
     * @Get("/authed")
     */
    public function authedAction()
    {
        $request = $this->request->get();
        $type = Member::TYPE_RIDE;
        if (!empty($request['type'])) {
            $type = $request['type'];
        }
        $request['type'] = $type;
        $request['status'] = Member::STATUS_AUTHED;
        $request['limit'] = $this->limit;
        $request['page'] = $this->page;
        $request['real_name'] = empty($request['real_name']) ? $request['real_name'] : "";
        $request['mobile'] = empty($request['mobile']) ? $request['mobile'] : "";
        $data = service("member/query")->getList($request);
        $this->view->setVars([
            'page' => $this->page,
            'data' => $data->items->toArray(),
            'total' => $data->total_items,
            'search' => $request
        ]);
    }

    /**
     * 列表
     * @Get("/auth_denied")
     */
    public function authDeniedAction()
    {
        $request = $this->request->get();
        $type = Member::TYPE_RIDE;
        if (!empty($request['type'])) {
            $type = $request['type'];
        }
        $request['type'] = $type;
        $request['status'] = Member::STATUS_AUTH_DENIED;
        $request['limit'] = $this->limit;
        $request['page'] = $this->page;
        $request['real_name'] = empty($request['real_name']) ? $request['real_name'] : "";
        $request['mobile'] = empty($request['mobile']) ? $request['mobile'] : "";
        $data = service("member/query")->getList($request);
        $this->view->setVars([
            'page' => $this->page,
            'data' => $data->items->toArray(),
            'total' => $data->total_items,
            'search' => $request
        ]);
    }

    /**
     * @Post("/auth/{id:[0-9]+}")
     * 审核用户资料
     */
    public function authAction($id)
    {

    }

    /**
     * @Put("/{id:[0-9]+}")
     */
    public function editAction()
    {

    }

}