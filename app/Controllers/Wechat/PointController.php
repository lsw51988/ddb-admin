<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-16
 * Time: 下午5:21
 */

namespace Ddb\Controllers\Wechat;


use Ddb\Controllers\WechatAuthController;

/**
 * Class PointController
 * 用户积分CUR操作
 * @RoutePrefix("/wechat/point")
 */
class PointController extends WechatAuthController
{
    /**
     * @Get("/{member_id:[0-9]+}")
     */
    public function showAction($memberId){

    }


    /**
     * @Post("/")
     */
    public function createAction(){

    }

    /**
     * @Put("/{member_id:[0-9]+}")
     */
    public function editAction($memberId){

    }

}