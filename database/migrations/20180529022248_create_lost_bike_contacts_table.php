<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateLostBikeContactsTable extends AbstractMigration
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
    //丢失车辆联系记录
    public function change()
    {
        $this->table("lost_bike_contacts")
            ->addColumn("lost_bike_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => false, "comment" => "lost_bike关联"])
            ->addColumn("member_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => false, "comment" => "联系人,member_bike关联"])
            ->addColumn("call_time", "timestamp", [ "null" => true, "comment" => "打电话时间"])
            ->addTimestamps()
            ->save();
    }
}
