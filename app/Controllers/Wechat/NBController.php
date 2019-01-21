<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-23
 * Time: 下午8:36
 */

namespace Ddb\Controllers\Wechat;


use Ddb\Controllers\WechatAuthController;
use Ddb\Models\Areas;
use Ddb\Models\NewBikeImgs;
use Ddb\Models\NewBikes;
use Ddb\Modules\Member;
use Ddb\Modules\MemberPoint;
use Ddb\Modules\NewBike;
use Ddb\Modules\Repair;
use Phalcon\Exception;

/**
 * Class SHBController
 * 新车 newBike
 * @RoutePrefix("/wechat/nb")
 */
class NBController extends WechatAuthController
{
    /**
     * @Post("/create")
     * 创建 新车信息
     */
    public function createAction()
    {
        $member = Member::findFirst($this->currentMember->getId());
        //需要首先判断用户积分是否足够
        $data = $this->data;
        if (!$points = service("nb/query")->hasEnoughPoint($member)) {
            return $this->error("积分不足");
        }
        if (!$repair = Repair::findFirstByBelongerId($member->getId())) {
            return $this->error("请先添加您的维修点店铺");
        }
        if ($repair->getStatus() != Repair::STATUS_PASS) {
            return $this->error("您的店铺尚未审核通过");
        }
        if ($newBikeId = service("nb/manager")->create($member, $repair, $data)) {
            return $this->success([
                "nb_id" => $newBikeId
            ]);
        }
        return $this->error();
    }

    /**
     * @Post("/update")
     * 修改新车信息
     */
    public function updateAction()
    {
        $member = $this->currentMember;
        $data = $this->data;
        if ($nbId = service("nb/manager")->update($member, $data)) {
            return $this->success();
        }
        return $this->error();
    }

    /**
     * @Post("/repub")
     * 重新发布新车信息
     */
    public function repubAction()
    {
        $member = $this->currentMember;
        $data = $this->data;

        if ($nbId = service("nb/manager")->repub($member, $data)) {
            return $this->success();
        }
        return $this->error();
    }

    /**
     * @Get("/revoke/{id:[0-9]+}")
     * 撤销新车
     */
    public function revokeAction($id)
    {
        $data = $this->data;
        $member = $this->currentMember;
        if ($nb = NewBike::findFirst($id)) {
            if ($nb->getMemberId() != $member->getId()) {
                return $this->error("非本人操作");
            }
            $nb->setStatus(NewBike::STATUS_CANCEL)->setCancelTime(date("Y-m-d H:i:s", time()))->setCancelReason($data['reason'])->save();
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

            $data['city'] = $area->getCityCode();
            $data['district'] = $district;
        }
        if (!empty($data['self_flag'])) {
            $data['member_id'] = $member->getId();
        }
        $rData = service("nb/query")->getList($data);
        return $this->success($rData);
    }

    /**
     * @Get("/detail/{id:[0-9]}")
     * 详情
     */
    public function detailAction($id)
    {
        $data = service("nb/query")->getNbDetail($id);
        return $this->success($data);
    }

    /**
     * @Post("/upload")
     * 上传新车照片
     */
    public function uploadAction()
    {
        $member = $this->currentMember;
        $file = $_FILES;
        $data = $this->data;
        $newBikeId = $data['new_bike_id'];
        $path = "NewBikeImages/" . $newBikeId . DIRECTORY_SEPARATOR . $file['file']['name'];
        $newBikeImage = new NewBikeImgs();
        $newBikeImage->setNewBikeId($newBikeId)
            ->setSize($file['file']['size'])
            ->setPath($path)
            ->setCreateBy($member->getId());
        if ($newBikeImage->save()) {
            try {
                service("file/manager")->saveFile($path, $file['file']['tmp_name']);
                return $this->success();
            } catch (Exception $e) {
                $newBikeImage->delete();
                app_log()->error("新车发布,member_id:" . $member->getId() . ";上传图片失败,原因是:" . $e->getMessage());
                return $this->error("图片保存失败");
            }
        } else {
            app_log()->error("新车发布,member_id:" . $member->getId() . ";保存MemberBikeImage记录失败");
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
        service("nb/manager")->contact($member, $id);
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
        $data = service("nb/query")->getManageDetail($id);
        return $this->success($data);
    }

    /**
     * @Get("/bikeImg/{id:[0-9]+}")
     * 查看电动车照片
     */
    public function bikeImgAction($id)
    {
        if (!$newBikeImage = NewBikeImgs::findFirst($id)) {
            return $this->error("找不到图片");
        }
        $path = $newBikeImage->getPath();
        $data = service("file/manager")->read($path);
        return $this->response->setContent($data)->setContentType('image/jpeg');
    }

    /**
     * @Delete("/bikeImg/{id:[0-9]+}")
     * 删除电动车照片
     */
    public function deleteBikeImgAction($id)
    {
        if ($newBikeImage = NewBikeImgs::findFirst($id)) {
            $path = $newBikeImage->getPath();
            if (service("file/manager")->deleteFile($path)) {
                $newBikeImage->delete();
                return $this->success();
            } else {
                app_log()->error("用户删除新车图片失败,bikeImageId=" . $newBikeImage->getId());
                return $this->error("删除图片失败");
            }
        }
        return $this->error("未找到或已经删除该记录");
    }
}