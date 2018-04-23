<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-23
 * Time: 下午8:13
 */

namespace Ddb\Controllers\Wechat;


use Ddb\Controllers\WechatAuthController;

/**
 * Class HomePageController
 * @package Ddb\Controllers\Wechat
 * @RoutePrefix("/homePage")
 */
class HomePageController extends WechatAuthController
{
    /**
     * @Get("/memberData")
     * 用户资料
     */
    public function memberDataAction(){

    }

    /**
     * @Get("/shop")
     * 商城
     */
    public function shopAction(){

    }

    /**
     * @Get("/recommend")
     * 推荐有奖
     */
    public function recommendAction(){

    }

    /**
     * @Get("/shb")
     * 二手车
     */
    public function shbAction(){

    }

    /**
     * @Get("/notice")
     * 用户须知
     */
    public function noticeAction(){

    }

    /**
     * @Get("/about")
     * 用户须知
     */
    public function aboutAction(){

    }

    /**
     * @Get("/insurance")
     * 保险
     */
    public function insuranceAction(){

    }

    /**
     * @Get("/record")
     * 我的记录
     */
    public function recordAction(){

    }

}