<?php


use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class CreateNewBikesTable extends AbstractMigration
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
    //新车
    public function change()
    {
        $this->table("new_bikes")
            ->addColumn("member_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => false, "comment" => "关联member"])
            ->addColumn("voltage", "integer", ["limit" => MysqlAdapter::INT_TINY, "null" => false, "comment" => "电压"])
            ->addColumn("brand_id", "integer", ["limit" => MysqlAdapter::INT_TINY, "null" => true, "comment" => "品牌对应brand表"])
            ->addColumn("brand_name", "string", ["limit" => MysqlAdapter::INT_TINY, "null" => false, "comment" => "品牌名"])
            ->addColumn("price", "decimal", ['precision' => 8, 'scale' => 2,"null" => false, "comment" => "价格"])
            ->addColumn("battery_brand", "string", ["limit" => MysqlAdapter::INT_TINY,"null" => false, "comment" => "电池品牌"])
            ->addColumn("distance", "integer", ["limit" => MysqlAdapter::INT_TINY,"null" => false, "comment" => "满负荷公里数"])
            ->addColumn("guarantee_period", "integer", ["limit" => MysqlAdapter::INT_TINY,"null" => false, "comment" => "质保期（月）"])
            ->addColumn("avail_time","timestamp", [ "null" => false, "comment" => "有效展示时间"])
            ->addColumn("province", "string", ['limit' => 8,"null" => false, "comment" => "所在省"])
            ->addColumn("city", "string", ['limit' => 8,"null" => false, "comment" => "所在市"])
            ->addColumn("district", "string", ['limit' => 8,"null" => false, "comment" => "所在区"])
            ->addColumn("province_code", "string", ['limit' => 20,"null" => false, "comment" => "所在省code"])
            ->addColumn("city_code", "string", ['limit' => 20,"null" => false, "comment" => "所在市code"])
            ->addColumn("district_code", "string", ['limit' => 20,"null" => false, "comment" => "所在区code"])
            ->addColumn("detail_addr", "string", ['limit' => 30,"null" => false, "comment" => "详细地址"])
            ->addColumn("remark", "string", ["limit" => MysqlAdapter::INT_TINY,"null" => true, "comment" => "备注"])
            ->addColumn("status", "integer", ["limit" => MysqlAdapter::INT_TINY,"default" => 1, "comment" => "状态 1提交 2审核成功 3审核失败 4自主取消"])
            ->addColumn("refuse_reason","string",["comment"=>"取消原因","null" => true])
            ->addColumn("cancel_time","timestamp",["comment"=>"取消时间","null" => true])
            ->addColumn("cancel_reason","string",["comment"=>"取消原因","null" => true])
            ->addTimestamps()
            ->save();
    }
}
