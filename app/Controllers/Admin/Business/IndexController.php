<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-15
 * Time: 上午9:20
 */

namespace Ddb\Controllers\Admin\Business;


use Ddb\Controllers\AdminAuthController;
use Ddb\Modules\Member;

/**
 * Class IndexController
 * @RoutePrefix("/admin/business")
 */
class IndexController extends AdminAuthController
{
    /**
     * @Get("/index")
     * 后台首页,数据统计等一些重要信息的显示,这里需要判断用户是否登录
     */
    public function indexAction()
    {

        //riders_count
        //repairer_count
        //shb_count
        //lost_count
        /*$this->view->setVars([
            "content"=>"这里是业务后台首页",
        ]);*/
        $this->view->setVars([
            "content" => "这里是业务后台首页",
        ]);
        $timeRange = [
            'start_time' => date("Y-m-d 00:00:00", strtotime("-1 day")),
            'end_time' => date("Y-m-d 23:59:59", strtotime("-1 day")),
        ];
        $riders_count = Member::count("created_at >= '".$timeRange['start_time']."' AND created_at <='".$timeRange['end_time']."' group by type");
        //$shb_count =
        $this->view->setVars([
            "riders_count" => $riders_count,
            //"repairer_count" => $repairer_count,
        ]);

    }
}