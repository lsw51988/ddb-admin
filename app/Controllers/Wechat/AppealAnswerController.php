<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-6-6
 * Time: 下午5:10
 */

namespace Ddb\Controllers\Wechat;


use Ddb\Controllers\WechatAuthController;

/**
 * Class AppealAnswerController
 * 响应请求
 * @RoutePrefix("/wechat/appeal_answer")
 */
class AppealAnswerController extends WechatAuthController
{
    /**
     * @Get("/near_appeals")
     * 获取周围的请求帮助列表
     * 前期需要用表记录每个修理者每天打开请求列表的记录.查看用户活跃度
     */
    public function indexAction()
    {
        $member = $this->currentMember;
        $data = $this->data;
        $longitude = $data['longitude'];
        $latitude = $data['latitude'];
        $appeals = service("appealanswer/query")->getNearAppealsByRadius($longitude, $latitude);
        service("appealanswer/manager")->browse($member->getId());
        if(sizeof($appeals)>0){
            return $this->success($appeals);
        }else{
            return $this->error("没有任何帮助请求");
        }

    }

    /**
     * @Get("/make_phone_call/{appeal_id:[0-9]+}")
     * 修理者打电话时记录
     */
    public function makeAppealCallAction($appealId)
    {
        $member = $this->currentMember;
        service("appealanswer/manager")->browse($member->getId(), $appealId);
        return $this->success();
    }

}