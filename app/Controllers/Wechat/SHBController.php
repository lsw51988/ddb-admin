<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-23
 * Time: 下午8:36
 */

namespace Ddb\Controllers\Wechat;


use Ddb\Controllers\WechatAuthController;
use Ddb\Models\SecondBikeImages;
use Ddb\Models\SecondBikes;
use Ddb\Modules\MemberPoint;
use Phalcon\Exception;

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
    public function createAction()
    {
        $member = $this->currentMember;
        if (!service("shb/query")->hasEnoughPoint($member)) {
            return $this->error("积分不足");
        }
        //需要首先判断用户积分是否足够
        $data = $this->data;

        if ($shbId = service("shb/manager")->create($member, $data)) {
            return $this->success([
                "shb_id" => $shbId
            ]);
        }
        return $this->error();
    }

    /**
     * @Put("/update")
     * 修改二手车信息
     */
    public function updateAction()
    {

    }

    /**
     * @Get("/list")
     * 列表
     */
    public function listAction()
    {

    }

    /**
     * @Get("/detail/{id:[0-9]}")
     * 详情
     */
    public function detailAction($id)
    {

    }

    /**
     * @Post("/upload")
     * 上传二手车照片
     */
    public function uploadAction()
    {
        $member = $this->currentMember;
        $file = $_FILES;
        $data = $this->data;
        $secondBikeId = $data['second_bike_id'];
        $path = "SecondBikeImages/" . $secondBikeId . DIRECTORY_SEPARATOR . $file['file']['name'];
        $secondBikeImage = new SecondBikeImages();
        $secondBikeImage->setSecondBikeId($secondBikeId)
            ->setSize($file['file']['size'])
            ->setPath($path)
            ->setCreateBy($member->getId());
        if ($secondBikeImage->save()) {
            try {
                service("file/manager")->saveFile($path, $file['file']['tmp_name']);
                return $this->success();
            } catch (Exception $e) {
                $secondBikeImage->delete();
                app_log()->error("二手车发布,member_id:" . $member->getId() . ";上传图片失败,原因是:" . $e->getMessage());
                return $this->error("图片保存失败");
            }
        } else {
            app_log()->error("二手车发布,member_id:" . $member->getId() . ";保存MemberBikeImage记录失败");
            return $this->error();
        }
    }

    /**
     * Post("/contact/{id:[0-9]+}")
     * 联系相应发布者
     */
    public function contactAction($id)
    {

    }

    /**
     * @Get("/browse/{id:[0-9]+}")
     * 浏览详情
     */
    public function browseAction($id)
    {

    }

}