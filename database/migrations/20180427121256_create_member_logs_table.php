<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateMemberLogsTable extends AbstractMigration
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
        $this->table("member_logs")
            ->addColumn("member_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR])
            ->addColumn("content", "string", ["limit" => 60, "comment" => "用户操作内容"])
            ->addColumn("type", "integer", ["limit" => 10, "comment" => "类型 0用户可见 1用户不可见", "default" => 0])
            ->addTimestamps()
            ->save();
    }
}
