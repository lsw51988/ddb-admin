<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateAppealsTable extends AbstractMigration
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
        $this->table("appeals")
            ->addColumn("ask_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => false, "comment" => "求助人id"])
            ->addColumn("awr_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => true, "comment" => "应答人id"])
            ->addColumn("method", "integer", ["limit" => 10, "comment" => "求助方式 1查看附近维修点 2请求拖车帮助"])
            ->addColumn("type", "integer", ["limit" => 50, "comment" => "故障类型"])
            ->addColumn("desc", "string", ["limit" => MysqlAdapter::INT_TINY, "null" => true, "comment" => "故障描述"])
            ->addColumn("mobile", "string", ["limit" => 11, "null" => true, "comment" => "手机号"])
            ->addColumn("longitude", "string", ["limit" => 10, "null" => true, "comment" => "经度"])
            ->addColumn("latitude", "string", ["limit" => 10, "null" => true, "comment" => "纬度"])
            ->addColumn("points", "integer", ["limit" => MysqlAdapter::INT_SMALL, "default" => 0, "comment" => "积分"])
            ->addColumn("updates", "integer", ["limit" => MysqlAdapter::INT_SMALL, "default" => 0, "comment" => "更新次数"])
            ->addColumn("update_desc", "string", ["limit" => 128, "default" => 0, "comment" => "更新描述"])
            ->addColumn("status", "integer", ["limit" => 128, "null" => false, "comment" => "状态 1请求帮助 2求助人自助取消 3时间到期系统取消
                4帮助人应答 5帮助完成"])
            ->addColumn("awr_time", "timestamp", ["null" => true, "comment" => "首次应答时间"])
            ->addColumn("awr_cancel_time", "timestamp", ["null" => true, "comment" => "应答取消时间"])
            ->addColumn("awr_fin_time", "timestamp", ["null" => true, "comment" => "应答完成时间"])
            ->addTimestamps()
            ->save();
    }
}
