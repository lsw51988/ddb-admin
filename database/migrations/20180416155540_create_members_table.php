<?php


use Phinx\Migration\AbstractMigration;

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
            ->addColumn("avatarUrl", "string", ["comment" => "微信头像", "limit" => 160, "null" => false])
            ->addColumn("province", "string", ["comment" => "所在省", "limit" => 6, "null" => false])
            ->addColumn("city", "string", ["comment" => "所在市", "limit" => 6, "null" => false])
            ->addColumn("district", "string", ["comment" => "所在区", "limit" => 6, "null" => false])
            ->addColumn("country", "string", ["comment" => "国家", "limit" => 10, "null" => false])
            ->addColumn("language", "string", ["comment" => "语言", "limit" => 10, "null" => false])
            ->addColumn("gender", "integer", ["comment" => "性别", "limit" => 2, "null" => false])
            ->addColumn("nickName", "string", ["comment" => "微信昵称", "limit" => 20, "null" => false])
            ->addColumn("mobile", "string", ["comment" => "电话", "limit" => 11, "null" => false])
            ->addColumn("points", "string", ["comment" => "可用积分", "limit" => 4, "null" => false])
            ->addColumn("type", "integer", ["comment" => "类型 1骑行者 2修理者", "limit" => 4, "default" => 1])
            ->addColumn("auth_time", "timestamp", ["comment" => "认证时间", "null" => true])
            ->addColumn("token_time", "timestamp", ["comment" => "token有效时间", "null" => true])
            ->addColumn("scene_code", "string", ["comment" => "场景值", "limit" => 6, "null" => true])
            ->addTimestamps()
            ->save();
    }
}
