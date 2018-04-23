<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-23
 * Time: 下午3:26
 */

namespace Ddb\Controllers\Wechat;


use Ddb\Controllers\WechatAuthController;

/**
 * Class IndexController
 * 请求帮助CUR操作
 * @RoutePrefix("/wechat/appeal")
 */
class AppealsController extends WechatAuthController
{
    /**
     * @Post("/create")
     * 骑行者发出帮助请求
     * 1.查询附近维修点,则返回附近维修点
     * 2.提供积分请求拖车帮助
     */
    public function createAction(){

    }

    /**
     * @Put("/update/{id:[0-9]+}")
     * 骑行者修改已发出的帮助请求
     */
    public function updateAction(){

    }

    /**
     * @Get("/query/{id:[0-9]+}")
     * 修理者查询附近帮助请求
     */
    public function queryAction(){

    }

    /**
     * @Post("/answer")
     * 修理者响应已发出的帮助请求
     * type:1自行推车 2请求拖车
     * id:对应的请求帮助id
     */
    public function answerAction(){

    }

    /**
     * @Post("/review")
     * 维修点回评
     * 需要appeal_id
     */
    public function reviewAction(){

    }


}