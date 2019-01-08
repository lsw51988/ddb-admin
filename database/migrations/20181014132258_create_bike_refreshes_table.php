<?php


use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class CreateBikeRefreshesTable extends AbstractMigration
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
    //车辆后台刷新纪录
    public function change()
    {
        $this->table("bike_refreshes")
            ->addColumn("bike_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => false, "comment" => "关联second_bikes"])
            ->addColumn("type", "integer", ["limit" => MysqlAdapter::INT_TINY, "null" => false, "comment" => "1新车 2二手车"])
            ->addColumn("member_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => false, "comment" => "用户id"])
            ->addTimestamps()
            ->save();
    }
}
