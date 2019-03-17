<?php
/**
 * Created by PhpStorm.
 * User: 阿德
 * Date: 2019/3/1
 * Time: 21:42
 */

namespace Ddb\Service\Suggestion;


use Ddb\Modules\Member;
use Ddb\Modules\Suggestion;
use Ddb\Service\BaseService;
use Phalcon\Paginator\Adapter\QueryBuilder;

class Query extends BaseService
{
    public function getAdminList($search)
    {
        $columns = "S.id,S.content,S.type,S.created_at,S.status,S.refuse_reason,M.real_name";
        $builder = $this->modelsManager->createBuilder()
            ->columns($columns)
            ->from(["S" => Suggestion::class])
            ->leftJoin(Member::class, "S.member_id = M.id", 'M');
        if (ok($search, 'status')) {
            $builder->andWhere("S.status = $search[status]");
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