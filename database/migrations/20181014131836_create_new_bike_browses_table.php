<?php


use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class CreateNewBikeBrowsesTable extends AbstractMigration
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
    //新车浏览记录
    public function change()
    {
        $this->table("new_bike_browses")
            ->addColumn("new_bike_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR])
            ->addColumn("member_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR])
            ->addColumn("call_time", "timestamp", [ "null" => true, "comment" => "打电话时间"])
            ->addTimestamps()
            ->save();
    }
}
