<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-15
 * Time: 上午9:20
 */

namespace Ddb\Controllers\Admin\Business;


use Ddb\Controllers\AdminAuthController;
use Ddb\Models\LostBikes;
use Ddb\Modules\Member;
use Ddb\Modules\SecondBike;

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
        $timeRange = [
            'start_time' => date("Y-m-d 00:00:00", strtotime("-1 day")),
            'end_time' => date("Y-m-d 23:59:59", strtotime("-1 day")),
        ];
        $conditions = "created_at>=:start_time: AND created_at<=:end_time:";
        $bind=[
            "start_time"=>$timeRange['start_time'],
            "end_time"=>$timeRange['end_time'],
        ];
        $memberCount = Member::count([
            "conditions"=>$conditions,
            "bind"=>$bind,
            "group"=>"type"
        ])->toArray();
        $countTypes = array_reduce($memberCount,function($countTypes,$v){
            $countTypes[$v['type']] = $v['rowcount'];
            return $countTypes;
        });
        if($countTypes==null){
            $riderCount = 0;
            $fixerCount = 0;
        }else{
            $riderCount = $countTypes[Member::TYPE_RIDE];
            $fixerCount = $countTypes[Member::TYPE_FIX];
        }
        $shbCount = SecondBike::count([
            "conditions"=>$conditions,
            "bind"=>$bind,
        ]);
        $lostCount = LostBikes::count([
            "conditions"=>$conditions,
            "bind"=>$bind,
        ]);

        $this->view->setVars([
            "riders_count" => $riderCount,
            "fixers_count" => $fixerCount,
            "shb_count" => $shbCount,
            "lost_count" => $lostCount
        ]);

    }
}