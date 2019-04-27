<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-18
 * Time: 上午11:54
 */

namespace Ddb\Service\User;


use Ddb\Core\Service;
use Ddb\Models\Users;
use Ddb\Modules\LostBike;
use Ddb\Modules\Member;
use Ddb\Modules\NewBike;
use Ddb\Modules\Repair;
use Ddb\Modules\RepairClaim;
use Ddb\Modules\SecondBike;
use Ddb\Modules\Suggestion;
use Ddb\Modules\User;

class Query extends Service
{
    public function getCurrentUser()
    {
        $user = unserialize($this->session->get("user_auth_identity"));
        return Users::findFirst($user['id']);
    }

    //获取今日的所有的统计信息包括 新增用户， 新增求助， 新增应助， 新增二手车， 新增新车， 新增维修点， 新增维修点认领， 新增丢失求助， 新增建议
    public function getAdminStatistic()
    {
        $data = [];
        $data['to_auth_users'] = Member::count('status = ' . Member::STATUS_TO_AUTH . ' AND updated_at>=\'' . date('Y-m-d 00:00:00').'\'');
        $data['to_auth_shb'] = SecondBike::count('status = ' . SecondBike::STATUS_CREATE . ' AND created_at>=\'' . date('Y-m-d 00:00:00').'\'');
        $data['to_auth_nb'] = NewBike::count('status = ' . NewBike::STATUS_CREATE . ' AND created_at>=\'' . date('Y-m-d 00:00:00').'\'');
        $data['to_auth_repairs'] = Repair::count('status = ' . Repair::STATUS_CREATE . ' AND created_at>=\'' . date('Y-m-d 00:00:00').'\'');
        $data['to_auth_claim_repairs'] = RepairClaim::count('status = ' . RepairClaim::STATUS_CREATE . ' AND created_at>=\'' . date('Y-m-d 00:00:00').'\'');
        $data['to_auth_lost_bikes'] = LostBike::count('status = ' . LostBike::STATUS_CREATE . ' AND created_at>=\'' . date('Y-m-d 00:00:00').'\'');
        $data['to_auth_suggestions'] = Suggestion::count('status = ' . Suggestion::STATUS_CREATE . ' AND created_at>=\'' . date('Y-m-d 00:00:00').'\'');
        return $data;
    }

}