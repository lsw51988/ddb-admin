<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateAppealCallbacksTable extends AbstractMigration
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
        $this->table("appeal_callbacks")
            ->addColumn("appeal_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "comment" => "对应appeals表", "null" => false])
            ->addColumn("wait_time", "integer", ["limit" => MysqlAdapter::INT_SMALL, "comment" => "等待时长（秒）", "null" => true])
            ->addColumn("fix_time", "integer", ["limit" => MysqlAdapter::INT_SMALL, "comment" => "维修时长（秒）", "null" => true])
            ->addColumn("price", "decimal", ['precision' => 6, 'scale' => 2, "comment" => "维修价格"])
            ->addColumn("score", "integer", ["limit" => MysqlAdapter::INT_TINY, "default" => 2, "comment" => "满意程度 1不满意 2基本满意 3满意 4非常满意"])
            ->addColumn("content", "string", ["limit" => MysqlAdapter::INT_TINY, "comment" => "其他想说的", "null" => true])
            ->addTimestamps()
            ->save();
    }
}
