<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateAppealBrowsesTable extends AbstractMigration
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
        $this->table("appeal_browses")
            ->addColumn("member_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR,"null" => false,  "comment" => "关联members"])
            ->addColumn("appeal_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => true, "comment" => "关联appeal"])
            ->addColumn("call_time", "timestamp", [ "null" => true, "comment" => "打电话时间"])
            ->addTimestamps()
            ->save();
    }
}
