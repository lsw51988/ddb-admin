<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-29
 * Time: 上午10:40
 */

namespace Ddb\Controllers\Wechat;


use Ddb\Controllers\WechatAuthController;
use Ddb\Models\LostBikes;
use Ddb\Models\MemberBikeImages;
use Ddb\Modules\Member;
use Ddb\Modules\MemberBike;
use Ddb\Models\Areas;
use Ddb\Modules\MemberPoint;


/**
 * Class LostController
 * 丢失车辆
 * @RoutePrefix("/wechat/lost")
 */
class LostController extends WechatAuthController
{
    /**
     * @Route("/create")
     * 创建丢失车辆
     */
    public function createAction()
    {
        $member = $this->currentMember;
        $currentMember = Member::findFirst($member->getId());
        if (!$memberBike = MemberBike::findFirstByMemberId($member->getId())) {
            return $this->error("您尚未添加您的车辆信息");
        }
        $memberBikeId = $memberBike->getId();
        if ($this->request->isGet()) {
            $bikeImages = MemberBikeImages::find([
                "columns" => "id",
                "conditions" => "member_bike_id = :member_bike_id:",
                "bind" => [
                    "member_bike_id" => $memberBikeId
                ]
            ])->toArray();
            $bikeImages = array_column($bikeImages, "id");
            for ($i = 0; $i < sizeof($bikeImages); $i++) {
                $bikeImages[$i] = di("config")->app->URL . "/wechat/member/bikeImg/" . $bikeImages[$i];
            }
            if ($lostBike = LostBikes::findFirstByMemberBikeId($memberBikeId)) {
                if ($area = Areas::findFirstByDistrictCode($lostBike->getDistrict())) {
                    $location = [];
                    $location[] = $area->getProvinceName();
                    $location[] = $area->getCityName();
                    $location[] = $area->getDistrictName();
                }

                return $this->success([
                    "lostBike" => $lostBike,
                    "location" => $location,
                    "bikeImages" => $bikeImages
                ]);
            } else {
                if ($area = Areas::findFirstByDistrictCode($member->getDistrict())) {
                    $location = [];
                    $location[] = $area->getProvinceName();
                    $location[] = $area->getCityName();
                    $location[] = $area->getDistrictName();
                }
                return $this->success([
                    "location" => $location,
                    "bikeImages" => $bikeImages
                ]);
            }
        } else {
            $data = $this->data;
            if ($data["lostBikeId"]) {
                $lostBike = LostBikes::findFirst($data["lostBikeId"]);
                if ($lostBike->getUpdatedAt() != null && strtotime($lostBike->getUpdatedAt()) >= strtotime(Date("Y-m-d 00:00:00"))) {
                    return $this->error("今日已经刷新过了,明天再来吧");
                }
                $lostBike->setUpdatedAt(Date("Y-m-d H:i:s", time()));
            } else {
                $lostBike = new LostBikes();
                if ($currentMember->getPoints() < 10) {
                    return $this->error("积分不足");
                }
            }
            $addr = explode(",", $data['addr']);
            $districtName = $addr['2'];
            $area = Areas::findFirstByDistrictName($districtName);
            $lostBike->setMemberId($member->getId())
                ->setMemberBikeId($memberBikeId)
                ->setLostDate($data['lost_date'])
                ->setProvince($area->getProvinceCode())
                ->setCity($area->getCityCode())
                ->setDistrict($area->getDistrictCode())
                ->setAddress($data['address'])
                ->setMemo($data['memo'])
                ->setRewards($data['rewards']);
            $this->db->begin();
            if (!$lostBike->save()) {
                $this->db->rollback();
                return $this->error("保存丢失车辆信息失败");
            }
            if (!$data["lostBikeId"]) {
                if (!service("point/manager")->create($currentMember, MemberPoint::TYPE_LOST_BIKE, null, null, $lostBike->getId())) {
                    $this->db->rollback();
                    return $this->error("积分保存失败");
                }
            }
            $this->db->commit();
            return $this->success();
        }
    }
}