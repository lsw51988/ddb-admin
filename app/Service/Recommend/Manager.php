<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-6-11
 * Time: 下午5:11
 */

namespace Ddb\Service\Recommend;


use Ddb\Core\Service;
use Ddb\Models\Recommends;

class Manager extends Service
{
    /**
     * @param $tId string 邀请人id
     * @param $bId string 被邀请人id
     * @return mixed
     */
    public function create($tId,$bId){
        if (!$recommend = Recommends::findFirst("t_id = " . $tId . " AND b_id = " . $bId)) {
            $recommend = new Recommends();
        }

        $recommend->setTId($tId)->setBId($bId);
        if (!$recommend->save()) {
            return false;
        }
        return true;
    }
}