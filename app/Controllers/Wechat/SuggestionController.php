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
     * @Post("/create")
     */
    public function createAction(){
        $data = $this->data;
        $memberId = $this->currentMember->getId();
        if(service("suggestion/manager")->create($memberId,$data)){
            return $this->success();
        }else{
            return $this->error("添加失败");;
        }
    }

    /**
     * @Get("/list")
     */
    public function listAction(){

    }
}