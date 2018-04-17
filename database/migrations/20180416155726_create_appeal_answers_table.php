<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateAppealAnswersTable extends AbstractMigration
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
        $this->table("appeal_answers")
            ->addColumn("appeal_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR,  "comment" => "对应appeals表","null" => false])
            ->addColumn("awr_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "comment" => "对应member","null" => false])
            ->addColumn("type", "integer", ["limit" => MysqlAdapter::INT_TINY,"default"=>1, "comment" => "1来自用户查看附近维修点 2.用户主动请求拖车帮助"])
            ->addColumn("status", "integer", ["limit" => MysqlAdapter::INT_TINY,"default"=>1, "comment" => "1开始帮助 2帮助完成 3取消帮助"])
            ->addColumn("cancel_reason", "string", ["limit" => MysqlAdapter::INT_TINY,"default"=>1, "comment" => "取消原因","null"=>true])
            ->addColumn("cancel_time", "timestamp", ["comment" => "取消时间","null"=>true])
            ->addColumn("create_time", "timestamp", ["comment" => "创建时间","default"=>])
            ->addColumn("second_bike_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => true, "comment" => "发布二手车时用到,对应second_bikes"])
            ->addColumn("appeal_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => true, "comment" => "求助拖车时用到 对应appeals"])
            ->addTimestamps()
            ->save();
    }
}
