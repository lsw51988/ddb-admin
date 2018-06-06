<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-6-6
 * Time: 下午5:16
 */

namespace Ddb\Service\Appealanswer;


use Ddb\Core\Service;
use Ddb\Modules\Appeal;
use Ddb\Modules\Member;

class Query extends Service
{
    public function getNearAppealsByRadius($longitude, $latitude, $radius = 1000)
    {
        $minLong = round($longitude - $radius / 1000 / 105, 5);
        $maxLong = round($longitude + $radius / 1000 / 105, 5);
        $minLati = round($latitude - $radius / 1000 / 105 / cos($latitude), 5);
        $maxLati = round($latitude + $radius / 1000 / 105 / cos($latitude), 5);

        $columns = ["A.longitude","A.latitude","A.created_at","A.type","A.method","M.real_name","M.mobile"];

        $builder = $this->modelsManager->createBuilder()
            ->from(["A"=>Appeal::class])
            ->leftJoin(Member::class,"A.ask_id = M.id","M")
            ->columns($columns)
            ->where("A.longitude >= $minLong")
            ->where("A.longitude <= $maxLong")
            ->where("A.latitude >= $minLati")
            ->where("A.latitude <= $maxLati")
            ->where("A.status = ".Appeal::STATUS_CREATE)
            ->where("A.created_at >= '".date("Y-m-d H:i:s", strtotime("-30 minutes")) . "'");
        $data = $builder->getQuery()->execute()->toArray();
        $rData = [];
        if(sizeof($data)>0){
            foreach($data as $k=>$v){
                if($v['method'] == Appeal::METHOD_SHOW){
                    $rData['show'][] = $v;
                }else{
                    $rData['sos'][] = $v;
                }
            }
        }

        return $rData;
    }

}