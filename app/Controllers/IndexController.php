<?php

namespace Ddb\Controllers;

use Ddb\Core\BaseController;
use Ddb\Models\MemberLogs;
use Ddb\Modules\MemberLog;

class IndexController extends BaseController
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        echo "欢饮来到我的帝国";
    }

    public function route404Action()
    {

    }

    /**
     * @Get("/test")
     */
    public function testAction()
    {
        $columns = ["content", "created_at"];
        $conditions = "member_id = :member_id:";
        $bind = [
            "member_id" => MemberLog::TYPE_VISIBLE
        ];
        $order = "created_at DESC";

        $data = MemberLogs::page($conditions, $columns, $bind, $order);

        return $this->success($data);
    }
}