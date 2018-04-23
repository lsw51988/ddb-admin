<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-23
 * Time: 下午7:30
 */

namespace Ddb\Controllers\Wechat;


use Ddb\Controllers\WechatAuthController;

/**
 * Class IndexController
 * 建议
 * @RoutePrefix("/wechat/suggestion")
 */
class SuggestionController extends WechatAuthController
{
    /**
     * @Post("/")
     */
    public function createAction(){

    }

    /**
     * @Get("/list")
     */
    public function listAction(){

    }
}