<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateMemberBikesTable extends AbstractMigration
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
        $this->table("member_bikes")
            ->addColumn("member_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => false, "comment" => "用户id"])
            ->addColumn("buy_date", "timestamp", ["null" => false, "comment" => "购买时间"])
            ->addColumn("voltage", "integer", ["limit" => MysqlAdapter::INT_TINY, "comment" => "电压"])
            ->addColumn("brand_id", "integer", ["limit" => MysqlAdapter::INT_TINY, "comment" => "品牌id"])
            ->addColumn("price", "decimal", ['precision' => 8, 'scale' => 2, "comment" => "价格"])
            ->addColumn("status", "integer", ["limit" => MysqlAdapter::INT_TINY, "default" => 1, "comment" => "1新的 2二手的"])
            ->addColumn("last_change_time", "timestamp", ["null" => true, "comment" => "最近一次更新电池时间"])
            ->addColumn("number", "string", ["null" => true, "comment" => "牌照"])
            ->addTimestamps()
            ->save();
    }
}
