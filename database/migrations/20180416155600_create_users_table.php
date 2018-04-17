<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateUsersTable extends AbstractMigration
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
    //后台用户表
    public function change()
    {
        $this->table("users")
            ->addColumn("name", "string", ["comment" => "姓名", "limit" => 20, "null" => false])
            ->addColumn("password", "string", ["comment" => "密码", "limit" => 40, "null" => false])
            ->addColumn("role_id", "integer", ["comment" => "角色id", "limit" => MysqlAdapter::INT_SMALL, "null" => false])
            ->addColumn("mobile", "string", ["comment" => "手机", "limit" => 11, "null" => false])
            ->addColumn("status", "integer", ["comment" => "状态 0不可用 1可用", "limit" => 2, "default" => 1])
            ->addColumn("email", "string", ["comment" => "邮箱", "limit" => 20, "null" => false])
            ->addColumn("create_by", "integer", ["comment" => "创建者", "limit" => 10, "null" => false])
            ->addColumn("update_by", "integer", ["comment" => "更新者", "limit" => 10, "null" => false])
            ->addColumn("department_id", "integer", ["comment" => "部门id", "limit" => 20, "null" => false])
            ->addTimestamps()
            ->save();
    }
}
