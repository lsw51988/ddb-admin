<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-23
 * Time: 下午8:36
 */

namespace Ddb\Controllers\Wechat;


use Ddb\Controllers\WechatAuthController;

/**
 * Class SHBController
 * 二手车 secondHandBike
 * @RoutePrefix("/wechat/shb")
 */
class SHBController extends WechatAuthController
{
    /**
     * @Post("/create")
     * 创建二手车信息
     */
    public function createAction(){

    }

    /**
     * @Put("/update")
     * 修改二手车信息
     */
    public function updateAction(){

    }

    /**
     * @Get("/list")
     * 列表
     */
    public function listAction(){

    }

    /**
     * @Get("/detail/{id:[0-9]}")
     * 详情
     */
    public function detailAction($id){

    }

    /**
     * @Post("/upload")
     * 上传二手车照片
     */
    public function uploadAction(){

    }

    /**
     * Post("/contact/{id:[0-9]+}")
     * 联系相应发布者
     */
    public function contactAction($id){

    }

    /**
     * @Get("/browse/{id:[0-9]+}")
     * 浏览详情
     */
    public function browseAction($id){

    }

}