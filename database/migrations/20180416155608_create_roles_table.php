<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateRolesTable extends AbstractMigration
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
    public function change()
    {
        $this->table("roles")
            ->addColumn("parent_id", "integer", ["limit" => MysqlAdapter::INT_SMALL, "default" => 0])
            ->addColumn("name", "string", ["limit" => 10, "null" => false, "comment" => "名称"])
            ->addColumn("desc", "string", ["limit" => 20, "comment" => "描述"])
            ->addColumn("status", "integer", ["limit" => 10, "default" => 1, "comment" => "状态 0禁用 1启用"])
            ->addColumn("create_by", "integer", ["limit" => MysqlAdapter::INT_SMALL, "null" => false, "comment" => "创建者"])
            ->addColumn("update_by", "integer", ["limit" => MysqlAdapter::INT_SMALL, "null" => false, "comment" => "更新着"])
            ->addTimestamps()
            ->save();
    }
}
