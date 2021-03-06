<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-23
 * Time: 下午3:26
 */

namespace Ddb\Controllers\Wechat;


use Ddb\Controllers\WechatAuthController;
use Ddb\Models\Areas;
use Ddb\Modules\Appeal;
use Ddb\Modules\Member;
use Ddb\Modules\MemberPoint;
use Ddb\Modules\SmsCode;

/**
 * Class IndexController
 * 请求帮助CUR操作
 * @RoutePrefix("/wechat/appeal")
 */
class AppealsController extends WechatAuthController
{
    /**
     * @Route("/create")
     * 骑行者发出帮助请求
     * 1.查询附近维修点,则返回附近维修点
     * 2.提供积分请求拖车帮助
     *
     * 同一个用户一次只能发送一个请求,所以需要判断用户之前是否有创建过的appeal,如果有则需要手动
     * 30分钟之内只能发送一条 每天最多发3次请求
     *
     */
    public function createAction()
    {
        $data = $this->data;
        $currentMember = $this->currentMember;
        if ($this->request->isGet()) {
            //1.检查30分钟之内是否有发送过请求
            if ($appeal = Appeal::findFirst([
                "conditions" => "created_at>='" . date("Y-m-d H:i:s", time() - 30 * 60) . "'",
                "order" => "created_at DESC"
            ])
            ) {
                return $this->success([
                    "mobile" => $currentMember->getMobile(),
                    "appeal" => $appeal
                ]);
            } else {
                return $this->success([
                    "mobile" => $currentMember->getMobile()
                ]);
            }
        } else {
            if (Appeal::count("created_at>='" . date("Y-m-d 00:00:00") . "' AND ask_id = " . $this->currentMember->getId()) > 3) {
                return $this->error("一天最多只能请求3次帮助");
            }
            $nearMts = service("repair/query")->getNearMtsByRadius($data['longitude'], $data['latitude']);
            if (sizeof($nearMts) == 0) {
                return $this->error('附近没有记录的维修点,您如果看到可手动添加,获得很多积分哦');
            }
            if (!ok($data, 'desc')) {
                return $this->error("请描述您的问题");
            }
            //暂时取消短信验证功能
//            if(!ok($data,'sms_code')){
//                return $this->error("请输入验证码");
//            }
//            //验证短信验证码
//            if (di("cache")->get($data['mobile'] . "_auth") != $data['sms_code']) {
//                return $this->error("短信验证码不正确或过期");
//            }
            if (isset($data['appeal_id'])) {
                $appeal = Appeal::findFirst($data['appeal_id']);
            } else {
                $appeal = new Appeal();
                $member = Member::findFirst($currentMember->getId());
                if ($member->getPoints() < 10) {
                    return $this->error("积分不足");
                }
            }
            $this->db->begin();
            if(!service("point/manager")->create($member, MemberPoint::TYPE_APPEAL_SOS, null, $appeal->getId())){
                $this->db->rollback();
                return $this->error("扣除积分失败");
            }
            //付费拖车服务 积分奖励暂时取消,前期并不会很拥挤 暂时取消拖车的服务
//            if ($data['method'] == Appeal::METHOD_SOS) {
//                $appeal->setPoints(10);
//            }
            $location = service("member/manager")->getLocation($data['latitude'], $data['longitude']);
            $appeal->setMethod($data['method'])
                ->setType($data['type'])
                ->setLongitude($data['longitude'])
                ->setLatitude($data['latitude'])
                ->setDescription($data['desc'])
                ->setAskId($currentMember->getId())
                ->setStatus(Appeal::STATUS_CREATE);
            //1.根据经纬度获取用户的当前地址
            if ($location->status != 0) {
                $appeal->setProvince($data['province'])
                    ->setCity($data['city'])
                    ->setDistrict($data['district']);
            } else {
                $area = Areas::findFirstByDistrictName($location->result->address_component->district);
                $appeal->setProvince($area->getProvinceCode())
                    ->setCity($area->getCityCode())
                    ->setDistrict($area->getDistrictCode());
            }
            if (!$appeal->save()) {
                $this->db->rollback();
                //di("cache")->delete($data['mobile'] . "_auth");
                return $this->success([
                    "appeal_id" => $appeal->getId()
                ]);
            }
            $this->db->commit();
            return $this->success();
        }
    }

    /**
     * @Put("/update/{id:[0-9]+}")
     * 骑行者修改已发出的帮助请求
     */
    public function updateAction()
    {

    }

    /**
     * @Get("/query/{id:[0-9]+}")
     * 修理者查询附近帮助请求
     */
    public function queryAction()
    {

    }

    /**
     * @Post("/answer")
     * 修理者响应已发出的帮助请求
     * type:1自行推车 2请求拖车
     * id:对应的请求帮助id
     */
    public function answerAction()
    {

    }

    /**
     * @Post("/review")
     * 维修点回评
     * 需要appeal_id
     */
    public function reviewAction()
    {

    }

    /**
     * @Get("/cancel/{appealId:[0-9]+}")
     * 取消求助
     * 需要验证是否为拖车服务,如果是拖车服务,确定是否有人已经抢单,如果有,则告知维修方用户已经取消
     */
    public function cancelAction($appealId)
    {
        $appeal = Appeal::findFirst($appealId);

        if ($appeal->getMethod() == Appeal::METHOD_SOS && $appeal->getStatus() == Appeal::STATUS_ANSWER) {
            $awrId = $appeal->getAwrId();
            if ($awr = Member::findFirst($awrId)) {
                if ($smsCode = service("sms/manager")->create($awr->getMobile(), SmsCode::TEMPLATE_CANCEL, SmsCode::TEMPLATE_CANCEL)) {
                    service("sms/manager")->send($smsCode->getId(), null, null);
                    //di("queue")->useTube("SmsCode")->put(serialize(['smsCodeId' => $smsCode->getId()]));
                }
            }
        }

        if ($appeal->setStatus(Appeal::STATUS_CANCEL)->save()) {
            return $this->success();
        }
        return $this->error();
    }
}