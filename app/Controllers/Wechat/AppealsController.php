<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-23
 * Time: 下午3:26
 */

namespace Ddb\Controllers\Wechat;


use Ddb\Controllers\WechatAuthController;
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
                "conditions" => "created_at>='" . Date("Y-m-d H:i:s", time() - 30 * 60) . "'",
                "order" => "created_at DESC"
            ])) {
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
            if (Appeal::count("created_at>='" . Date("Y-m-d 00:00:00") . "'") > 3) {
                return $this->error("一天最多只能请求3次帮助");
            }
            $nearMts = service("repair/query")->getNearMtsByRadius($data['longitude'], $data['latitude']);
            if (sizeof($nearMts) == 0) {
                return $this->error([
                    "no_repairs" => true
                ]);
            }

            //验证短信验证码
            if (di("cache")->get($data['mobile'] . "_auth") != $data['sms_code']) {
                return $this->error("短信验证码不正确或过期");
            }
            if (isset($data['appeal_id'])) {
                $appeal = Appeal::findFirst($data['appeal_id']);
            } else {
                $appeal = new Appeal();
                $member = Member::findFirst($currentMember->getId());
                if ($member->getPoints() < 10) {
                    return $this->error("积分不足");
                }
                service("point/manager")->create($member, MemberPoint::TYPE_APPEAL_SOS, null, $appeal->getId());
                $member->setPoints($member->getPoints() + MemberPoint::TYPE_APPEAL_SOS)->save();
            }
            //付费拖车服务 积分奖励暂时取消,前期并不会很拥挤
            if ($data['method'] == Appeal::METHOD_SOS) {
                $appeal->setPoints(10);
            }
            $appeal->setMethod($data['method'])
                ->setType($data['type'])
                ->setLongitude($data['longitude'])
                ->setLatitude($data['latitude'])
                ->setDescription($data['desc'])
                ->setAskId($currentMember->getId())
                ->setStatus(Appeal::STATUS_CREATE);
            if ($appeal->save()) {
                di("cache")->delete($data['mobile'] . "_auth");
                return $this->success([
                    "appeal_id" => $appeal->getId()
                ]);

            } else {
                return $this->error("保存不成功");
            }
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
                    di("queue")->useTube("SmsCode")->put(serialize(['smsCodeId' => $smsCode->getId()]));
                }
            }
        }

        if ($appeal->setStatus(Appeal::STATUS_CANCEL)->save()) {
            return $this->success();
        }
        return $this->error();
    }
}