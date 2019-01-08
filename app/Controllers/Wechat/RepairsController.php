<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-23
 * Time: 下午2:42
 */

namespace Ddb\Controllers\Wechat;


use Ddb\Controllers\WechatAuthController;
use Ddb\Models\Areas;
use Ddb\Models\RepairAuthImages;
use Ddb\Models\RepairImages;
use Ddb\Modules\Member;
use Ddb\Modules\MemberPoint;
use Ddb\Modules\Repair;
use Phalcon\Exception;

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
    public function createAction()
    {
        $member = $this->currentMember;
        $data = $this->data;
        //验证短信验证码
        $mobile = $member->getMobile();
        if (!service("sms/manager")->verify($mobile, $data['sms_code'])) {
            return $this->error("短信验证码不正确,请重新获取");
        }
        if (Repair::findFirstByMobile($mobile)) {
            return $this->error("该维修点已经添加");
        }
        $repair = new Repair();
        $repair->setName($data['name'])
            ->setBelongerName($data['belonger_name'])
            ->setType($data['type'])
            ->setLongitude($data['longitude'])
            ->setLatitude($data['latitude'])
            ->setMobile($data['mobile'])
            ->setRemark($data['remark'])
            ->setAddress($data['address'])
            ->setCreateBy($member->getId())
            ->setStatus(Repair::STATUS_NOT_OWNER_CREATE);
        $location = service("member/manager")->getLocation($data['latitude'], $data['longitude']);
        if ($location->status != 0) {
            $repair->setProvince('未知')
                ->setCity('未知')
                ->setDistrict('未知');
        } else {
            $area = Areas::findFirstByDistrictName($location->result->address_component->district);
            $repair->setProvince($area->getProvinceCode())
                ->setCity($area->getCityCode())
                ->setDistrict($area->getDistrictCode());
        }
        if ($data['belong_creator'] == 1) {
            $repair->setBelongerId($member->getId())
                ->setStatus(Repair::STATUS_OWNER_CREATE);
        }
        $this->db->begin();
        if (!$repair->save()) {
            app_log()->error("用户增加维修点错误,member_id:" . $member->getId());
            return $this->error("维修点记录保存失败");
        }
        $currentMember = Member::findFirst($member->getId());
        if (!service("point/manager")->create($currentMember, MemberPoint::TYPE_ADD_REPAIRS)) {
            return $this->error("积分变更失败");
        }
        $this->db->commit();
        return $this->success(["repair_id" => $repair->getId()]);
    }

    /**
     * @Post("/claim")
     * 用户认领店铺
     */
    public function claimAction()
    {
        $data = $this->data;
        $mobile = $data['mobile'];
        $member = $this->currentMember;
        if (!service("sms/manager")->verify($mobile, $data['sms_code'])) {
            return $this->error("短信验证码不正确,请重新获取");
        }
        if ($repair = Repair::findFirst($data['repair_id'])) {
            if ($mobile != $repair->getMobile()) {
                return $this->error("您的手机号与系统所留的手机号码不一致,请检查");
            }
            $repair->setBelongerId($member->getId())
                ->setStatus(Repair::STATUS_CLAIM)
                ->setLongitude($data['longitude'])
                ->setLatitude($data['latitude']);
            if ($repair->save()) {
                return $this->success();
            } else {
                return $this->error();
            }
        }
    }

    /**
     * @Put("/update/{id:[0-9]+}")
     * 用户更新店铺
     */
    public function updateAction()
    {

    }

    /**
     * @Get("/query/{id:[0-9]+}")
     * 用户查询店铺
     */
    public function queryAction()
    {

    }

    /**
     * @Post("/upload")
     * 上传店铺照片
     */
    public function uploadAction()
    {
        $member = $this->currentMember;
        $file = $_FILES;
        $data = $this->data;
        $repairId = $data['repair_id'];

        $path = "RepairsImages/" . $repairId . DIRECTORY_SEPARATOR . uniqid() . $file['file']['name'];
        $repairImage = new RepairImages();
        $repairImage->setRepairId($repairId)
            ->setSize($file['file']['size'])
            ->setPath($path)
            ->setCreateBy($member->getId());
        if ($repairImage->save()) {
            try {
                service("file/manager")->saveFile($path, $file['file']['tmp_name']);
                return $this->success();
            } catch (Exception $e) {
                $repairImage->delete();
                app_log()->error("增加维修点信息,上传人member_id:" . $member->getId() . ";repair_id:" . $repairId . ";上传图片失败,原因是:" . $e->getMessage());
                return $this->error("图片保存失败");
            }
        } else {
            app_log()->error("增加维修点信息,上传人,member_id:" . $member->getId() . ";repair_id:" . $repairId . ";保存RepairImage记录失败");
            return $this->error($repairId);
        }
    }

    /**
     * @Post("/upload_auth")
     * 上传店铺认领时的照片
     */
    public function upload_authAction()
    {
        $member = $this->currentMember;
        $file = $_FILES;
        $data = $this->data;
        $repairId = $data['repair_id'];

        $path = "RepairsAuthImages/" . $repairId . DIRECTORY_SEPARATOR . uniqid() . $file['file']['name'];
        $repairAuthImage = new RepairAuthImages();
        $repairAuthImage->setRepairId($repairId)
            ->setSize($file['file']['size'])
            ->setPath($path)
            ->setCreateBy($member->getId());
        if ($repairAuthImage->save()) {
            try {
                service("file/manager")->saveFile($path, $file['file']['tmp_name']);
                return $this->success();
            } catch (Exception $e) {
                $repairAuthImage->delete();
                app_log()->error("增加维修点信息,上传人member_id:" . $member->getId() . ";repair_id:" . $repairId . ";上传图片失败,原因是:" . $e->getMessage());
                return $this->error("图片保存失败");
            }
        } else {
            app_log()->error("增加维修点信息,上传人,member_id:" . $member->getId() . ";repair_id:" . $repairId . ";保存RepairImage记录失败");
            return $this->error($repairId);
        }
    }

    /**
     * @Post("/near_mts")
     * 获取附近维修点的,根据半径进行筛选
     */
    public function near_mtsAction()
    {
        $data = $this->data;
        $longitude = $data['longitude'];
        $latitude = $data['latitude'];
        $nearMts = service("repair/query")->getNearMtsByRadius($longitude, $latitude);
        return $this->success($nearMts);
    }

    /**
     * @Get("/{repairId:[0-9]+}/images")
     * 根据维修点id获取他的照片
     */
    public function repairImgsAction($repairId)
    {
        $images = RepairImages::find([
            "columns" => "id",
            "conditions" => "repair_id = $repairId"
        ]);
        $data = [];
        foreach ($images as $image) {
            $data[] = di("config")->app->URL . "/wechat/repair/repairImg/" . $image['id'];
        }
        return $this->success($data);
    }

    /**
     * @Get("/repairImg/{id:[0-9]+}")
     * 查看维修点照片
     */
    public function repairImgAction($id)
    {
        if (!$repairImage = RepairImages::findFirst($id)) {
            return $this->error("找不到图片");
        }
        $path = $repairImage->getPath();
        $data = service("file/manager")->read($path);
        return $this->response->setContent($data['contents'])->setContentType('image/jpeg');
    }
}