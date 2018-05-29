<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreatePointOrdersTable extends AbstractMigration
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
    //积分订单
    public function change()
    {
        $this->table("point_orders")
            ->addColumn("member_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => false, "comment" => "member关联"])
            ->addColumn("number", "string", ["limit" => 50, "null" => false, "comment" => "订单号"])
            ->addColumn("amount", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => false, "comment" => "充值金额"])
            ->addColumn("status", "integer", ["limit" => MysqlAdapter::INT_TINY, "default" => 1,"comment" => "状态 1创建 2成功 3失败"])
            ->addColumn("memo", "string", ["comment" => "备注信息", "limit" => 40, "null" => true])
            ->addTimestamps()
            ->save();
    }
}
