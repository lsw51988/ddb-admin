<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateRepairApprisesTable extends AbstractMigration
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
        $this->table("repair_appraises")
            ->addColumn("repair_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => false, "comment" => "维修点id"])
            ->addColumn("score", "integer", ["limit" => 5, "default" => 2, "comment" => "1不满意 2基本满意 3满意 4非常满意"])
            ->addColumn("desc", "string", ["limit" => MysqlAdapter::INT_TINY, "null" => true, "comment" => "附加描述"])
            ->addColumn("member_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => false, "comment" => "评论人"])
            ->addTimestamps()
            ->save();
    }
}
