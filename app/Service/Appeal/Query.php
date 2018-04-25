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
use Ddb\Service\BaseService;

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
}