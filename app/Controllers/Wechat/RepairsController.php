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
use Ddb\Modules\Repair;
use Ddb\Modules\RepairClaim;
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
        $repair = new Repair();
        $repair->setName($data['name'])
            ->setBelongerName($data['belonger_name'])
            ->setType($data['type'])
            ->setLongitude($data['longitude'])
            ->setLatitude($data['latitude'])
            ->setRemark($data['remark'])
            ->setAddress($data['address'])
            ->setCreateBy($member->getId())
            ->setStatus(Repair::STATUS_CREATE);
        if (ok($data, 'belong_creator') && $data['belong_creator'] == 1) {
            $repair->setBelongerId($member->getId());
        }
        if (ok($data, 'mobile')) {
            //验证短信验证码
            if (!service("sms/manager")->verify($data['mobile'], $data['sms_code'])) {
                return $this->error("短信验证码不正确,请重新获取");
            }
            if (Repair::findFirstByMobile($data['mobile'])) {
                return $this->error("该维修点已经添加");
            }
            $repair->setMobile($data['mobile']);
        }
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
        $this->db->begin();
        if (!$repair->save()) {
            app_log()->error("用户增加维修点错误,member_id:" . $member->getId());
            return $this->error("维修点记录保存失败");
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
        if (!service("sms/manager")->verify($mobile, $data['sms_code'])) {
            return $this->error("短信验证码不正确,请重新获取");
        }
        if ($repair = Repair::findFirst($data['repair_id'])) {
            $repairClaimModel = new RepairClaim();
            if ($repairClaimModel->findFirstByMemberId($this->currentMember->getId())) {
                return $this->error('请勿重复申请');
            }
            $repairClaimData = [
                'member_id' => $this->currentMember->getId(),
                'mobile' => $data['mobile'],
                'name' => $data['name'],
                'repair_id' => $data['repair_id']
            ];
            if ($repairClaimModel->save($repairClaimData)) {
                return $this->success();
            } else {
                return $this->error('操作失败，请将该页面截图发电动帮公众号，我们将及时处理');
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
        return $this->response->setContent($data)->setContentType('image/jpeg');
    }

    /**
     * @Get("/repairClaimImg/{id:[0-9]+}")
     * 查看维修点照片
     */
    public function repairClaimImgAction($id)
    {
        if (!$repairImage = RepairAuthImages::findFirst($id)) {
            return $this->error("找不到图片");
        }
        $path = $repairImage->getPath();
        $data = service("file/manager")->read($path);
        return $this->response->setContent($data)->setContentType('image/jpeg');
    }
}