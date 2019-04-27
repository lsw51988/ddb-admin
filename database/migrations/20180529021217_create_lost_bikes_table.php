<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateLostBikesTable extends AbstractMigration
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
    //丢失车辆记录
    public function change()
    {
        $this->table("lost_bikes")
            ->addColumn("member_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => false, "comment" => "失主,member关联"])
            ->addColumn("member_bike_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => false, "comment" => "member_bike关联"])
            ->addColumn("lost_date", "timestamp", ["null" => false, "comment" => "丢失时间"])
            ->addColumn("province", "string", ["comment" => "所在省", "limit" => 6, "null" => false])
            ->addColumn("city", "string", ["comment" => "所在市", "limit" => 6, "null" => false])
            ->addColumn("district", "string", ["comment" => "所在区", "limit" => 6, "null" => false])
            ->addColumn("address", "string", ["comment" => "详细地址", "limit" => 50, "null" => false])
            ->addColumn("memo", "string", ["comment" => "备注信息", "limit" => 200, "null" => false])
            ->addColumn("rewards", "integer", ["comment" => "悬赏信息", "limit" => MysqlAdapter::INT_SMALL, "null" => false])
            ->addColumn("contact_time", "timestamp", ["comment" => "找车者最近一次联系失主时间", "null" => true])
            ->addColumn("finish_time", "timestamp", ["comment" => "失主确认找到时间", "null" => true])
            ->addColumn("fail_time", "timestamp", ["comment" => "失主放弃查找时间", "null" => true])
            ->addTimestamps()
            ->save();
    }
}
