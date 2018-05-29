<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-29
 * Time: 下午3:03
 */

namespace Ddb\Service\Suggestion;


use Ddb\Core\Service;
use Ddb\Modules\Member;
use Ddb\Modules\MemberPoint;
use Ddb\Modules\Suggestion;

class Manager extends Service
{
    public function create($memberId,$data){
        $this->db->begin();
        $suggestion = new Suggestion();
        $suggestion->setMemberId($memberId)
            ->setContent($data['content'])
            ->setType($data['type'])
            ->setStatus(Suggestion::STATUS_CREATE);
        if(!$suggestion->save()){
            $this->db->rollback();
            return false;
        }
        $member = Member::findFirst($memberId);
        if(!service("point/manager")->create($member, MemberPoint::TYPE_SUGGESTION)){
            $this->db->rollback();
            return false;
        }
        $this->db->commit();
        return true;
    }

}