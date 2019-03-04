<?php
namespace Ddb\Service\RepairClaim;

use Ddb\Models\Areas;
use Ddb\Modules\Repair;
use Ddb\Modules\RepairClaim;
use Ddb\Modules\User;
use Ddb\Service\BaseService;
use Phalcon\Paginator\Adapter\QueryBuilder;

/**
 * Created by PhpStorm.
 * User: 阿德
 * Date: 2019/3/4
 * Time: 23:40
 */
class Query extends BaseService
{
    /**
     * 获取维修点申领列表
     * @param $request
     * @return \stdClass
     */
    public function getList($request)
    {
        $columns = ['RC.id', 'RC.name', 'RC.status','RC.mobile', 'RC.created_at', 'RC.reason','R.name as repair_name','R.address', 'A.district_name', 'A.city_name', 'A.province_name', 'U.name as user_name'];
        $builder = $this->modelsManager->createBuilder()
            ->from(["RC" => RepairClaim::class])
            ->leftJoin(Repair::class, "RC.repair_id = R.id", "R")
            ->leftJoin(Areas::class, "A.district_code = R.district", "A")
            ->leftJoin(User::class, "RC.user_id = U.id", "U")
            ->columns($columns);
        if (ok($request, 'status')) {
            $builder->andWhere("RC.status=" . $request['status']);
        }
        if (ok($request, 'province')) {
            $builder->andWhere("R.province =" . $request['province']);
        }
        if (ok($request, 'city')) {
            $builder->andWhere("R.city =" . $request['city']);
        }
        if (ok($request, 'district')) {
            $builder->andWhere("R.district =" . $request['district']);
        }
        $paginator = new QueryBuilder([
            'builder' => $builder,
            'limit' => $request['limit'],
            'page' => $request['page']
        ]);
        $data = $paginator->getPaginate();
        return $data;
    }


}