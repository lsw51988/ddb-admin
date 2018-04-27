<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-23
 * Time: 下午8:13
 */

namespace Ddb\Controllers\Wechat;


use Ddb\Controllers\WechatAuthController;
use Ddb\Models\MemberBikes;
use Ddb\Modules\Member;

/**
 * Class HomePageController
 * @package Ddb\Controllers\Wechat
 * @RoutePrefix("/wechat/homePage")
 */
class HomePageController extends WechatAuthController
{

    /**
     * @Get("/index")
     * 用户主页
     *
     * times骑行者代表求助次数 修理者代表应助次数
     * 暂时无返回交易次数
     */
    public function indeAction()
    {
        $member = $this->currentMember;
        $data = [];
        $point = service("member/query")->getTotalPoints($member);
        $data['level'] = service("member/query")->getLevel($point);
        $data['times'] = 0;
        if ($member->getType() == Member::TYPE_RIDE) {
            $data['times'] = service("appeal/query")->getAskCount($member);
        }
        if ($member->getType() == Member::TYPE_FIX) {
            $data['times'] = service("appeal/query")->getAnswerCount($member);
        }
        return $this->success($data);
    }

    /**
     * @Get("/memberData")
     * 用户资料
     */
    public function memberDataAction()
    {
        $memberBikeData = [];
        $memberId = $this->currentMember->getId();
        $memberKeys = ['id', 'real_name', 'mobile'];
        $memberData = Member::getColumnValues($memberId, $memberKeys);
        if ($memberBike = MemberBikes::findFirstByMemberId($memberId)) {
            $bikeKeys = ['buy_date', 'voltage', 'brand_name', 'price', 'status', 'last_change_time'];
            $memberBikeData = MemberBikes::getColumnValues($memberBike->getId(), $bikeKeys);
        }
        $data = array_merge($memberData, $memberBikeData);
        return $this->success($data);
    }

    /**
     * @Get("/shop")
     * 商城
     */
    public function shopAction()
    {

    }

    /**
     * @Get("/recommend")
     * 推荐有奖
     */
    public function recommendAction()
    {

    }

    /**
     * @Get("/shb")
     * 二手车
     */
    public function shbAction()
    {

    }

    /**
     * @Get("/notice")
     * 用户须知
     */
    public function noticeAction()
    {

    }

    /**
     * @Get("/about")
     * 关于
     */
    public function aboutAction()
    {

    }

    /**
     * @Get("/insurance")
     * 保险
     */
    public function insuranceAction()
    {

    }

    /**
     * @Get("/record")
     * 我的记录
     */
    public function recordAction()
    {

    }

}