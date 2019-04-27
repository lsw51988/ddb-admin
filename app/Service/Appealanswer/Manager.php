<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-6-6
 * Time: 下午5:46
 */

namespace Ddb\Service\Appealanswer;


use Ddb\Core\Service;
use Ddb\Models\AppealBrowses;

class Manager extends Service
{
    public function browse($memberId,$appealId=null){
        $appealBrowse = new AppealBrowses();
        $appealBrowse->setMemberId($memberId);
        if($appealId!=null){
            $appealBrowse->setAppealId($appealId)->setCallTime(date("Y-m-d H:i:s",time()));
        }
        $appealBrowse->save();
    }
}