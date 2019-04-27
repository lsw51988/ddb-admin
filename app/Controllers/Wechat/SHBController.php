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
use Ddb\Models\Areas;
use Ddb\Modules\Member;
use Ddb\Modules\MemberPoint;
use Ddb\Modules\SecondBike;
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
        $member = Member::findFirst($this->currentMember->getId());
        $data = $this->data;
        //需要首先判断用户积分是否足够
        if (!$points = service("shb/query")->hasEnoughPoint($member)) {
            return $this->error("积分不足");
        }
        if ($shbId = service("shb/manager")->create($member, $data)) {
            return $this->success([
                "shb_id" => $shbId
            ]);
        }
        return $this->error('发布失败');
    }

    /**
     * @Post("/update")
     * 修改二手车信息
     */
    public function updateAction()
    {
        $member = $this->currentMember;
        $data = $this->data;
        if ($shbId = service("shb/manager")->update($member, $data)) {
            return $this->success();
        }
        return $this->error('更新失败');
    }

    /**
     * @Post("/repub")
     * 重新发布二手车信息
     */
    public function repubAction()
    {
        $member = $this->currentMember;
        $data = $this->data;

        if ($shbId = service("shb/manager")->repub($member, $data)) {
            return $this->success();
        }
        return $this->error();
    }

    /**
     * @Get("/revoke/{id:[0-9]+}")
     * 撤销二手车
     */
    public function revokeAction($id)
    {
        $data = $this->data;
        $member = $this->currentMember;
        if ($shb = SecondBike::findFirst($id)) {
            if ($shb->getMemberId() != $member->getId()) {
                return $this->error("非本人操作");
            }
            $shb->setStatus(SecondBike::STATUS_CANCEL)->setCancelTime(date("Y-m-d H:i:s", time()))->setCancelReason($data['reason']);
            if ($shb->save()) {
                return $this->success();
            } else {
                return $this->error('操作失败');
            }
        } else {
            return $this->error("未找到该条记录");
        }
    }

    /**
     * @Get("/deal/{id:[0-9]+}")
     * 成交二手车
     */
    public function dealAction($id)
    {
        $member = $this->currentMember;
        if ($shb = SecondBike::findFirst($id)) {
            if ($shb->getMemberId() != $member->getId()) {
                return $this->error("非本人操作");
            }
            $shb->setStatus(SecondBike::STATUS_DEAL)->setDealTime(date("Y-m-d H:i:s", time()))->save();
            return $this->success();
        } else {
            return $this->error("未找到该条记录");
        }
    }


    /**
     * @Get("/list")
     * 列表
     * 根据当前用户的地址自动筛选出当前区域的车辆
     * 需要返回用户当前的地址
     */
    public function listAction()
    {
        $member = $this->currentMember;
        $data = $this->data;
        if (!isset($data['district'])) {
            $district = $member->getDistrict();
            $area = Areas::findFirstByDistrictCode($district);
            $data['city_code'] = $area->getCityCode();
        } else {
            $area = Areas::findFirstByDistrictName($data['district']);
            $data['city_code'] = $area->getCityCode();
            $data['district_code'] = $area->getDistrictCode();
        }
        if (!empty($data['self_flag'])) {
            $data['member_id'] = $member->getId();
        }
        $rData = service("shb/query")->getList($data);
        return $this->success($rData);
    }

    /**
     * @Get("/detail/{id:[0-9]}")
     * 详情
     */
    public function detailAction($id)
    {
        $data = service("shb/query")->getShbDetail($id);
        return $this->success($data);
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
     * @Get("/contact/{id:[0-9]+}")
     * 联系相应发布者
     */
    public function contactAction($id)
    {
        $member = $this->currentMember;
        service("shb/manager")->contact($member, $id);
        return $this->success();
    }

    /**
     * @Get("/browse/{id:[0-9]+}")
     * 浏览详情
     */
    public function browseAction($id)
    {
        $member = $this->currentMember;
        service("shb/manager")->browse($member, $id);
        return $this->success();
    }

    /**
     * @Get("/manage_detail/{id:[0-9]+}")
     * 管理详情
     */
    public function manageDetailAction($id)
    {
        $data = service("shb/query")->getManageDetail($id);
        return $this->success($data);
    }

    /**
     * @Get("/bikeImg/{id:[0-9]+}")
     * 查看电动车照片
     */
    public function bikeImgAction($id)
    {
        if (!$secondBikeImage = SecondBikeImages::findFirst($id)) {
            return $this->error("找不到图片");
        }
        $path = $secondBikeImage->getPath();
        $data = service("file/manager")->read($path);
        return $this->response->setContent($data)->setContentType('image/jpeg');
    }

    /**
     * @Delete("/bikeImg/{id:[0-9]+}")
     * 删除电动车照片
     */
    public function deleteBikeImgAction($id)
    {
        if ($secondBikeImage = SecondBikeImages::findFirst($id)) {
            $path = $secondBikeImage->getPath();
            if (service("file/manager")->deleteFile($path)) {
                $secondBikeImage->delete();
                return $this->success();
            } else {
                app_log()->error("用户删除二手车图片失败,bikeImageId=" . $secondBikeImage->getId());
                return $this->error("删除图片失败");
            }
        }
        return $this->error("未找到或已经删除该记录");
    }
}