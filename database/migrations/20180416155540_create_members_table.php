<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateMembersTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    //前台用户表
    public function change()
    {
        $this->table("members")
            ->addColumn("avatar_url", "string", ["comment" => "头像", "limit" => 160, "null" => true])
            ->addColumn("province", "string", ["comment" => "所在省", "limit" => 6, "null" => false])
            ->addColumn("city", "string", ["comment" => "所在市", "limit" => 6, "null" => false])
            ->addColumn("district", "string", ["comment" => "所在区", "limit" => 6, "null" => false])
            ->addColumn("gender", "integer", ["comment" => "性别", "limit" => 2, "null" => true])
            ->addColumn("nick_name", "string", ["comment" => "微信昵称", "limit" => 20, "null" => true])
            ->addColumn("real_name", "string", ["comment" => "真实姓名", "limit" => 20, "null" => true])
            ->addColumn("mobile", "string", ["comment" => "电话", "limit" => 11, "null" => true])
            ->addColumn("points", "integer", ["comment" => "可用积分", "limit" => 1000000, "default" => 0])
            ->addColumn("type", "integer", ["comment" => "类型 1骑行者 2修理者", "limit" => 4, "default" => 1])
            ->addColumn("auth_time", "timestamp", ["comment" => "认证时间", "null" => true])
            ->addColumn("token", "string", ["comment" => "token", "null" => true, "limit" => 50])
            ->addColumn("token_time", "timestamp", ["comment" => "token有效时间", "null" => true])
            ->addColumn("scene_code", "string", ["comment" => "场景值", "limit" => 6, "null" => true])
            ->addColumn("open_id", "string", ["comment" => "小程序openid", "limit" => 50, "null" => true])
            ->addColumn("platform_open_id", "string", ["comment" => "微信开放平台openid", "limit" => 50, "null" => true])
            ->addColumn("union_id", "string", ["comment" => "union_id", "limit" => 50, "null" => true])
            ->addColumn("status", "integer", ["comment" => "状态 1初次注册 2提交认证 3认证通过 4认证拒绝", "limit" => MysqlAdapter::INT_TINY, "default" => 1])
            ->addColumn("privilege", "integer", ["comment" => "会员状态 0普通会员 1会员", "limit" => MysqlAdapter::INT_TINY, "default" => 0])
            ->addColumn("privilege_time", "timestamp", ["comment" => "会员到期时间", "null" => true])
            ->addTimestamps()
            ->save();
    }
}
