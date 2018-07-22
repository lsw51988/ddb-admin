<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-15
 * Time: 下午4:19
 */

namespace Ddb\Controllers\Admin\Business;

use Ddb\Controllers\AdminAuthController;
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
    public function auditAction(){

    }

    /**
     * @Delete("/{id:[0-9]+}")
     */
    public function deleteAction($id){

    }

    /**
     * @Put("/{id:[0-9]+}")
     */
    public function editAction(){

    }

    /**
     * @Get("/{id:[0-9]+}")
     */
    public function showAction(){

    }

    /**
     * @Get("/list")
     */
    public function listAction(){
        $request = $this->request->get();
        $request['limit'] = $this->limit;
        $request['page'] = $this->page;
        $data = service("shb/query")->getAdminList($request);
        $this->view->setVars([
            'page' => $this->page,
            'data' => $data->items->toArray(),
            'total' => $data->total_items,
            'search' => $request
        ]);
    }
}