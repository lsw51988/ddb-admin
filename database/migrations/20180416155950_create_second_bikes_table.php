<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateSecondBikesTable extends AbstractMigration
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
        $this->table("second_bikes")
            ->addColumn("member_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => false, "comment" => "关联member"])
            ->addColumn("buy_date", "date", ["null" => false,  "comment" => "购买时间"])
            ->addColumn("voltage", "integer", ["limit" => MysqlAdapter::INT_TINY, "null" => false, "comment" => "电压"])
            ->addColumn("brand_id", "integer", ["limit" => MysqlAdapter::INT_TINY, "null" => true, "comment" => "品牌对应brand表"])
            ->addColumn("brand_name", "string", ["limit" => MysqlAdapter::INT_TINY, "null" => false, "comment" => "品牌名"])
            ->addColumn("in_price", "decimal", ['precision' => 8, 'scale' => 2,"null" => false, "comment" => "买入时价格"])
            ->addColumn("in_status", "integer", ["limit" => MysqlAdapter::INT_TINY,"default" => 1, "comment" => "买入时状态1新的 2二手的"])
            ->addColumn("out_price", "decimal", ['precision' => 8, 'scale' => 2,"null" => false, "comment" => "出价"])
            ->addColumn("deal_price", "decimal", ['precision' => 8, 'scale' => 2,"null" => true, "comment" => "成交价格"])
            ->addColumn("province", "string", ['limit' => 8,"null" => false, "comment" => "所在省"])
            ->addColumn("city", "string", ['limit' => 8,"null" => false, "comment" => "所在市"])
            ->addColumn("district", "string", ['limit' => 8,"null" => false, "comment" => "所在区"])
            ->addColumn("province_code", "string", ['limit' => 20,"null" => false, "comment" => "所在省code"])
            ->addColumn("city_code", "string", ['limit' => 20,"null" => false, "comment" => "所在市code"])
            ->addColumn("district_code", "string", ['limit' => 20,"null" => false, "comment" => "所在区code"])
            ->addColumn("detail_addr", "string", ['limit' => 30,"null" => false, "comment" => "详细地址"])
            ->addColumn("number", "string", ['limit' => 20,"null" => false, "comment" => "车牌号"])
            ->addColumn("remark", "string", ["limit" => MysqlAdapter::INT_TINY,"null" => true, "comment" => "备注"])
            ->addColumn("status", "integer", ["limit" => MysqlAdapter::INT_TINY,"default" => 1, "comment" => "状态 1提交 2自主取消 3成功交易 4状态异常"])
            ->addColumn("last_change_time","timestamp",["comment"=>"最近一次更换电瓶时间","null" => true])
            ->addColumn("avail_time","timestamp",["comment"=>"有效展示时间","null" => true])
            ->addColumn("deal_time","timestamp",["comment"=>"成交时间","null" => true])
            ->addColumn("cancel_time","timestamp",["comment"=>"取消时间","null" => true])
            ->addColumn("cancel_reason","string",["comment"=>"取消原因","null" => true])
            ->addTimestamps()
            ->save();
    }
}
