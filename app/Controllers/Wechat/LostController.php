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
use Ddb\Modules\BikeRefresh;
use Ddb\Modules\LostBike;
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
            if ($lostBike = LostBikes::findFirst("member_id=" . $memberBikeId . " AND status!=" . LostBike::STATUS_FOUND)) {
                $area = Areas::findFirstByDistrictCode($lostBike->getDistrict());
                $location = [];
                $location[] = $area->getProvinceName();
                $location[] = $area->getCityName();
                $location[] = $area->getDistrictName();
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
            $lostBike = new LostBikes();
            if ($currentMember->getPoints() < MemberPoint::$typeScore[MemberPoint::TYPE_LOST_BIKE]) {
                return $this->error("积分不足");
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

    /**
     * @Post("/refresh")
     * 刷新丢失车辆
     */
    public function refreshAction()
    {
        $data = $this->data;
        if ($lostBike = LostBike::findFirst($data['lostBikeId'])) {
            if ($lostBike->getStatus() == LostBike::STATUS_CREATE) {
                return $this->error('还未通过审核，刷新无用');
            }
            if (service('lost/manager')->refresh($lostBike)) {
                $todayRefreshCount = BikeRefresh::count('bike_id = ' . $lostBike->getId() . ' AND type = ' . BikeRefresh::TYPE_LOST . ' AND created_at>=\'' . date('Y-m-d 00:00:00') . '\'');
                return $this->success([
                    'left_refresh_count' => 2 - $todayRefreshCount
                ]);
            } else {
                return $this->error('刷新失败');
            }
        } else {
            return $this->error('未找到该记录');
        }
    }

    /**
     * @Post("/revoke")
     * 撤回丢失车辆
     */
    public function revokeAction()
    {
        $data = $this->data;
        if ($lostBike = LostBike::findFirst($data['lostBikeId'])) {
            if (service('lost/manager')->revoke($lostBike, $data)) {
                return $this->success();
            } else {
                return $this->error('刷新失败');
            }
        } else {
            return $this->error('未找到该记录');
        }
    }

    /**
     * @Get("/list")
     */
    public function listAction()
    {
        $member = $this->currentMember;
        $data = $this->data;
        if (!ok($data, 'district')) {
            $district = $member->getDistrict();
            $area = Areas::findFirstByDistrictCode($district);
            $data['city'] = $area->getCityCode();
        } else {
            $area = Areas::findFirst([
                'conditions' => "city_name = '" . $data['city'] . "' AND district_name = '" . $data['district'] . "'"
            ]);
            $data['city'] = $area->getCityCode();
            $data['district'] = $area->getDistrictCode();
        }
        $rData = service("lost/query")->getList($data);
        return $this->success($rData);
    }

    /**
     * @Get("/contact/{id:[0-9]+}")
     * 联系相应发布者
     */
    public function contactAction($id)
    {
        $member = $this->currentMember;
        service("lost/manager")->contact($member, $id);
        return $this->success();
    }

    /**
     * @Get("/detail/{id:[0-9]}")
     * id值得是lostBikeId
     * 详情
     */
    public function detailAction($id)
    {
        $data = service("lost/query")->getDetail($id);
        return $this->success($data);
    }

    /**
     * @Get("/browse/{id:[0-9]+}")
     * 浏览详情
     */
    public function browseAction($id)
    {
        $member = $this->currentMember;
        service("lost/manager")->browse($member, $id);
        return $this->success();
    }
}