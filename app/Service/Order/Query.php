<?php
/**
 * Created by PhpStorm.
 * User: 阿德
 * Date: 2018/10/23
 * Time: 22:39
 */

namespace Ddb\Service\Order;


use Ddb\Models\Areas;
use Ddb\Modules\Member;
use Ddb\Modules\Order;
use Ddb\Service\BaseService;
use Phalcon\Paginator\Adapter\QueryBuilder;

class Query extends BaseService
{
    public function getList($search){
        $columns = "O.id,O.member_id,O.body,O.total_fee,O.created_at,M.real_name,M.mobile,A.province_name,A.city_name,A.district_name";
        $builder = $this->modelsManager->createBuilder()
            ->columns($columns)
            ->from(["O" => Order::class])
            ->leftJoin(Member::class, "O.member_id = M.id", 'M')
            ->leftJoin(Areas::class, "A.district_code = M.district", "A");
        if (!empty($search['real_name'])) {
            $builder->andWhere('M.real_name LIKE %' . $search['real_name'] . '%');
        }
        if (!empty($search['mobile'])) {
            $builder->andWhere('M.mobile LIKE %' . $search['mobile'] . '%');
        }
        if (!empty($search['province'])) {
            $builder->andWhere('A.province_code = ' . $search['province']);
        }
        if (!empty($search['city'])) {
            $builder->andWhere('A.city_code = ' . $search['city']);
        }
        if (!empty($search['district'])) {
            $builder->andWhere('A.district_code = ' . $search['district']);
        }
        if (!empty($search['start_time'])) {
            $builder->andWhere('O.created_at >= ' . $search['start_time']);
        }
        if (!empty($search['end_time'])) {
            $builder->andWhere('O.created_at <= ' . $search['end_time']);
        }
        $paginator = new QueryBuilder([
            'builder' => $builder,
            'limit' => $search['limit'],
            'page' => $search['page']
        ]);
        $data = $paginator->getPaginate();
        return $data;
    }
}