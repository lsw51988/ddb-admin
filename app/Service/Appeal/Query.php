<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-24
 * Time: 下午11:48
 */

namespace Ddb\Service\Appeal;


use Ddb\Models\Appeals;
use Ddb\Models\Members;
use Ddb\Modules\Member;
use Ddb\Service\BaseService;
use Phalcon\Paginator\Adapter\QueryBuilder;

class Query extends BaseService
{
    /**
     * @param Members $member
     * @return integer
     * 获取求助记录次数
     */
    public function getAskCount(Members $member)
    {
        return Appeals::count([
            "columns" => "id",
            "conditions" => "ask_id = :member_id:",
            "bind" => [
                "member_id" => $member->getId()
            ]
        ]);
    }

    /**
     * @method getAnswerCount
     * @param Members $member
     * @return integer
     * 获取应助记录次数
     */
    public function getAnswerCount(Members $member)
    {
        return Appeals::count([
            "columns" => "id",
            "conditions" => "awr_id = :member_id:",
            "bind" => [
                "member_id" => $member->getId()
            ]
        ]);
    }

    /**
     * 获取求助list
     */
    public function getList($request)
    {
        $columns = ["A.id", "A.method", "A.type", "A.description", "A.mobile", "A.longitude", "A.longitude", "A.status", "A.awr_time", "A.awr_cancel_time", "A.awr_fin_time", "A.created_at", "M.real_name"];
        $builder = $this->modelsManager->createBuilder()
            ->from(["A" => Appeals::class])
            ->leftJoin(Member::class, "A.ask_id = M.id", "M")
            ->columns($columns);
        if (!empty($request['status'])) {
            $builder->andWhere("A.status=" . $request['status']);
        }
        if (!empty($request['real_name'])) {
            $builder->andWhere("M.real_name like '%" . $request['real_name'] . "%'");
        }
        if (!empty($request['mobile'])) {
            $builder->andWhere("A.mobile = " . $request['mobile']);
        }
        if (!empty($request['type'])) {
            $builder->andWhere("A.type =" . $request['type']);
        }
        $paginator = new QueryBuilder([
            'builder' => $builder,
            'limit' => $this->limit,
            'page' => $this->page
        ]);
        $data = $paginator->getPaginate();
        return $data;
    }
}