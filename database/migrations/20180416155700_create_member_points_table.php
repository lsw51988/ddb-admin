<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateMemberPointsTable extends AbstractMigration
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
        $this->table("member_points")
            ->addColumn("member_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => false])
            ->addColumn("type", "integer", ["limit" => 10, "null" => false, "comment" => "类型"])
            ->addColumn("value", "integer", ["limit" => 50, "comment" => "类别数值"])
            ->addColumn("second_bike_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => true, "comment" => "发布二手车时用到,对应second_bikes"])
            ->addColumn("appeal_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => true, "comment" => "求助拖车时用到 对应appeals"])
            ->addTimestamps()
            ->save();
    }
}
