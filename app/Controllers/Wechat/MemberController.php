<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-23
 * Time: 下午7:53
 */

namespace Ddb\Controllers\Wechat;


use Ddb\Controllers\WechatAuthController;
use Ddb\Models\MemberSignCollects;
use Ddb\Models\MemberSigns;
use Ddb\Modules\BikeRefresh;
use Ddb\Modules\Member;
use Ddb\Modules\MemberBike;
use Ddb\Modules\MemberPoint;
use Ddb\Modules\SmsCode;
use Ddb\Models\MemberBikeImages;
use Phalcon\Exception;

/**
 * Class MemberController
 * 维修点CUR操作
 * @RoutePrefix("/wechat/member")
 */
class MemberController extends WechatAuthController
{
    /**
     * @Post("/auth")
     * 用户完善重要信息
     */
    public function authAction()
    {
        $data = $this->data;
        $mustKeys = [
            "real_name" => "姓名",
            "mobile" => "手机号",
            "sms_code" => "短信验证码",
            "brand_name" => "品牌",
            "buy_date" => "购买日期",
            "number" => "车牌号",
            "voltage" => "电池容量",
            "price" => "价格",
            "status" => "购买时状态"
        ];
        foreach ($mustKeys as $k => $v) {
            if ($data[$k] == "") {
                return $this->error($v . "是必填项:");
            }
        }
        $data['voltage'] = MemberBike::$voltageDesc[$data['voltage']];
        $data['buy_date'] = $data['buy_date'] . "-01";
        if ($data['last_change_time']) {
            $data['last_change_time'] = $data['last_change_time'] . "-01";
        }
        //验证短信验证码
        if (di("cache")->get($data['mobile'] . "_auth") != $data['sms_code']) {
            return $this->error("短信验证码不正确或过期");
        }
        $memberId = $this->currentMember->getId();
        $member = Member::findFirst($memberId);
        $this->db->begin();
        $member->setRealName($data['real_name'])
            ->setMobile($data['mobile'])
            ->setAuthTime(date("Y-m-d H:i:s", time()));

        if (!$member->save()) {
            $this->db->rollback();
            return $this->error("个人用户信息保存失败");
        }
        if (!$memberBike = MemberBike::findFirstByMemberId($memberId)) {
            $memberBike = new MemberBike();
        }
        $memberBike->setMemberId($member->getId())
            ->setBrandName($data['brand_name'])
            ->setBuyDate($data['buy_date'] . " 00:00:00")
            ->setNumber($data['number'])
            ->setVoltage($data['voltage'])
            ->setPrice($data['price'])
            ->setStatus($data['status']);
        if (ok($data, 'last_change_time')) {
            $memberBike->setLastChangeTime($data['last_change_time'] . ' 00:00:00');
        }
        if (!$memberBike->save()) {
            $this->db->rollback();
            return $this->error("个人用户车辆信息保存失败");
        }
        $this->db->commit();
        di("cache")->delete($data['mobile'] . "_auth");

        //需要重写缓存
        //$token = $this->token;
        //service("member/manager")->freshCache($token, $member);
        return $this->success(
            [
                "member_bike_id" => $memberBike->getId()
            ]
        );
    }

    /**
     * @Get("/auth")
     * 获取用户的重要信息
     */
    public function authShowAction()
    {
        $currentMember = $this->currentMember;
        $data = service("member/query")->getAuthInfo($currentMember);
        return $this->success($data);
    }

    /**
     * @Post("/smsCode")
     * 获取短信验证码
     */
    public function smsCodeAction()
    {
        $token = $this->token;
        $data = $this->data;
        if (!service("sms/manager")->canSend($data['mobile'])) {
            return $this->error("已经超过今日发送短信上限");
        }
        if (Member::findFirst("mobile=$data[mobile] AND id!=" . $this->currentMember->getId())) {
            return $this->error("该手机已被注册！");
        }
        $code = service("sms/manager")->getSmsCode();
        $smsCode = new SmsCode();
        $smsCodeData['mobile'] = $data['mobile'];
        $smsCodeData['code'] = $code;
        $smsCodeData['status'] = SmsCode::STATUS_SENDING;
        $smsCodeData['template'] = SmsCode::TEMPLATE_INDEX;

        if ($smsCode->save($smsCodeData)) {
            $key = $data['mobile'] . "_auth";
            di("cache")->save($key, $code, 5 * 60);
            if (service("sms/manager")->send($smsCode->getId(), $token, $data)) {
                return $this->success("发送成功");
            }

            //di("queue")->useTube("SmsCode")->put(serialize(['smsCodeId' => $smsCode->getId(), 'token' => $token, 'data' => []]));
            //return $this->success("发送成功");
        } else {
            return $this->error("发送失败");
        }
    }

    /**
     * @Post("/upload")
     * @Param member_bike_id
     * 上传电车照片
     */
    public function uploadAction()
    {
        $member = $this->currentMember;
        $file = $_FILES;
        $data = $this->data;
        $memberBikeId = $data['member_bike_id'];
        $path = "MemberBikeImages/" . $member->getId() . DIRECTORY_SEPARATOR . uniqid() . $file['file']['name'];
        $memberBikeImage = new MemberBikeImages();
        $memberBikeImage->setMemberBikeId($memberBikeId)
            ->setSize($file['file']['size'])
            ->setPath($path)
            ->setCreateBy($member->getId());
        if ($memberBikeImage->save()) {
            try {
                service("file/manager")->saveFile($path, $file['file']['tmp_name']);
                return $this->success();
            } catch (Exception $e) {
                $memberBikeImage->delete();
                app_log()->error("用户认证,member_id:" . $member->getId() . ";上传图片失败,原因是:" . $e->getMessage());
                return $this->error("图片保存失败");
            }
        } else {
            app_log()->error("用户认证,member_id:" . $member->getId() . ";保存MemberBikeImage记录失败");
            return $this->error($memberBikeId);
        }
    }

    /**
     * @Get("/bikeImg/{id:[0-9]+}")
     * 查看电动车照片
     */
    public function bikeImgAction($id)
    {
        ob_clean();
        header("Content-type:image/jpeg");
        if (!$memberBikeImage = MemberBikeImages::findFirst($id)) {
            return $this->error("找不到图片");
        }
        $path = $memberBikeImage->getPath();
        $data = service("file/manager")->read($path);
        $this->response->setContentType('image/jpeg');
        $this->response->setContent($data);
        return $this->response;
    }

    /**
     * @Delete("/bikeImg/{id:[0-9]+}")
     * 删除电动车照片
     */
    public function deleteBikeImgAction($id)
    {
        if ($memberBikeImage = MemberBikeImages::findFirst($id)) {
            $path = $memberBikeImage->getPath();
            if (service("file/manager")->deleteFile($path)) {
                $memberBikeImage->delete();
                return $this->success();
            } else {
                app_log()->error("用户删除电动车图片失败,bikeImageId=" . $memberBikeImage->getId());
                return $this->error("删除图片失败");
            }
        }
        return $this->error("未找到或已经删除该记录");
    }

    /**
     * @Route("/baseInfo")
     * 获取用户的头像和昵称信息
     */
    public function baseInfoAction()
    {
        $member = $this->currentMember;
        if ($this->request->isGet()) {
            if ($member->getAvatarUrl() == null) {
                $data['avatar_url'] = "";
            } else {
                preg_match('/https/', $member->getAvatarUrl(), $matches);
                if (sizeof($matches) > 0) {
                    $data['avatar_url'] = $member->getAvatarUrl();
                } else {
                    $data['avatar_url'] = di("config")->app->URL . "/wechat/avatar?path=" . $member->getAvatarUrl();
                }
            }
            $data['nick_name'] = $member->getNickName();
            return $this->success($data);
        } else {
            $file = $_FILES;
            $data = $this->data;
            $this->db->begin();
            if ($file != []) {
                $path = "AvatarImages/" . $member->getId() . '-' . $file['file']['name'];
                if (!service("member/manager")->updateAvatar($member, $file)) {
                    $this->db->rollback();
                    return $this->error();
                }
            } else {
                $path = $member->getAvatarUrl();
            }
            if (!ok($data, 'nick_name')) {
                $data['nick_name'] = '骑行侠';
            }
            $member->setNickName($data['nick_name'])->setAvatarUrl($path);
            if (!$member->save()) {
                $this->db->rollback();
                return $this->error("用户信息保存错误");
            }
            $this->db->commit();
            $rData = [];
            $rData['nickName'] = $member->getNickName();
            $rData['auth_time'] = $member->getAuthTime();
            $rData['avatarUrl'] = $member->getAvatarUrl();
            $rData['id'] = $member->getId();
            $rData['token'] = $member->getToken();
            return $this->success($rData);
        }
    }

    /**
     * @Post("/userInfo")
     */
    public function unionIdAction()
    {
        $data = $this->data;
        $iv = $data['iv'];
        $encryptedData = $data['encryptedData'];
        $appId = di("config")->app->APP_ID;
        $memberId = $this->currentMember->getId();
        if ($this->currentMember->getUnionId()) {
            return $this->success();
        }
        if ($sessionKey = di("cache")->get($memberId . '_sessionKey')) {
            if ($sData = service("member/manager")->getDecryptData($memberId, $appId, $sessionKey, $encryptedData, $iv)) {
                $member = Member::findFirst($memberId);
                if ($unionId = $sData->unionId) {
                    $member->setUnionId($sData->unionId)
                        ->setAvatarUrl($data['avatarUrl'])
                        ->setNickName($data['nickName'])
                        ->setStatus(Member::STATUS_TO_AUTH)
                        ->setGender($data['gender']);
                    if (!$member->save()) {
                        return $this->error("保存用户信息错误");
                    }
                    return $this->success([
                        "avatarUrl" => $member->getAvatarUrl(),
                        "nickName" => $member->getNickName()
                    ]);
                }
            } else {
                return $this->error("没有sData");
            }
        } else {
            return $this->error("没有sessionKey");
        }
    }

    /**
     * @Get("/mobile")
     * 获取用户的mobile信息
     */
    public function mobileAction()
    {
        $currentMember = $this->currentMember;
        $mobile = $currentMember->getMobile();
        if ($mobile) {
            return $this->success(
                [
                    "mobile" => $mobile
                ]
            );
        }
        return $this->error();
    }

    /**
     * @Post("/sign")
     * 连续七天签到的话则多增加10个积分
     */
    public function signAction()
    {
        $member = $this->currentMember;
        if (MemberSigns::findFirst("member_id = " . $member->getId() . " AND created_at>='" . date("Y-m-d 00:00:00", time()) . "'")) {
            return $this->error("今日已经签过");
        } else {
            if ($msg = service('sign/manager')->sign($member)) {
                return $this->success(null, $msg);
            } else {
                return $this->error('请稍后重试');
            }
        }
    }

    /**
     * @Post("/become_privilege")
     * 成为会员
     */
    public function becomePrivilegeAction()
    {
        $request = $this->data;
        $member = $this->currentMember;
        if ($member->getPoints() < $request['point']) {
            return $this->error('积分不足');
        }
        $type = MemberPoint::getPrivilegeType($request['point']);
        $month = MemberPoint::getPrivilegeMonth($request['point']);
        $this->db->begin();
        //1.扣除积分
        if (!service('point/manager')->create($member, $type)) {
            $this->db->rollback();
            return $this->error('积分扣除失败');
        }
        //变更会员
        if (!service('member/manager')->becomePrivilege($member, $month, 'month')) {
            $this->db->rollback();
            return $this->error('更改会员失败');
        }
        $this->db->commit();
        return $this->success();
    }

    /**
     * @Get("/flush")
     * 刷新车辆
     */
    public function flushAction()
    {
        $request = $this->data;
        $type = $request['type'];
        $bikeId = $request['bike_id'];
        $request['member_id'] = $this->currentMember->id;
        $needPoint = false;
        $bikeRefresh = new BikeRefresh();
        $count = $bikeRefresh->count("type = $type AND bike_id = $bikeId AND created_at >= '" . date('Y-m-d 00:00:00') . "'");
        if ($count >= 3) {
            $needPoint = true;
        }
        if (service("refresh/manager")->refresh($request, $needPoint)) {
            $count = 2 - $count;
            return $this->success($count);
        }
        return $this->error();
    }

    /**
     * 获取用户积分记录
     * @Get("/point_log")
     */
    public function pointLogAction()
    {
        $data = service("member/query")->getPointLog($this->currentMember, $this->data);
        return $this->success($data);
    }

    /**
     * 获取用户消息记录
     * @Get("/messages")
     */
    public function messagesAction()
    {
        $data = service("member/query")->getMessages($this->currentMember, $this->data);
        return $this->success($data);
    }

    /**
     * 用户在添加维修点之前检查附近是否有维修点，如果有则打开认领页面，否则直接进入添加页面
     * @Post("/checkNearMts")
     */
    public function checkNearMtsAction()
    {
        $request = $this->data;
        $scale = !isset($data['scale']) ? 18 : $data['scale'];
        $radius = service('repair/query')->getRadiusByScale($scale);
        if (service('repair/query')->getNearMtsByRadius($request['longitude'], $request['latitude'], $radius)) {
            return $this->success();
        } else {
            return $this->error();
        }
    }
}