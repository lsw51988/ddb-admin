<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-23
 * Time: 下午2:42
 */

namespace Ddb\Controllers\Wechat;


use Ddb\Controllers\WechatAuthController;
use Ddb\Models\RepairImages;
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
        if (!service("sms/manager")->verify($mobile,$data['sms_code'])) {
            return $this->error("短信验证码不正确,请重新获取");
        }
        if(Repair::findFirstByMobile($mobile)){
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
            ->setCreateBy($member->getId());
        if ($data['belong_creator'] == 1) {
            $repair->setBelongerId($member->getId());
        }
        $this->db->begin();
        if (!$repair->save()) {
            app_log()->error("用户增加维修点错误,member_id:" . $member->getId());
            return $this->error("维修点记录保存失败");
        }
        if (!service("point/manager")->create($member, MemberPoint::TYPE_ADD_REPAIRS)) {
            return $this->error("积分变更失败");
        }
        $this->db->commit();
        return $this->success(["repair_id" => $repair->getId()]);
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

        $path = "RepairsImages/" . $repairId . DIRECTORY_SEPARATOR . $file['file']['name'];
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
}