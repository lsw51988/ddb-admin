<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-23
 * Time: 下午2:42
 */

namespace Ddb\Controllers\Wechat;


use Ddb\Controllers\WechatAuthController;

/**
 * Class RepairsController
 * 维修点CUR操作
 * @RoutePrefix("/wechat/repair")
 */
class RepairsController extends WechatAuthController
{
    /**
     * @Post("/create")
     * 用户添加店铺
     */
    public function createAction(){

    }

    /**
     * @Put("/update/{id:[0-9]+}")
     * 用户更新店铺
     */
    public function updateAction(){

    }

    /**
     * @Get("/query/{id:[0-9]+}")
     * 用户查询店铺
     */
    public function queryAction(){

    }

    /**
     * @Post("/upload")
     * 上传店铺照片
     */
    public function uploadAction(){

    }
}