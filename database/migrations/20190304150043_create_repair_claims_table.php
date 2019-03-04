<?php


use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class CreateRepairClaimsTable extends AbstractMigration
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
    //维修点申领记录
    public function change()
    {
        $this->table('repair_claims')
            ->addColumn("name", "string", ["limit" => MysqlAdapter::INT_TINY, "null" => false, "comment" => "用户姓名"])
            ->addColumn("member_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => false, "comment" => "用户id"])
            ->addColumn("repair_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => false, "comment" => "维修点id"])
            ->addColumn("status", "integer", ["limit" => MysqlAdapter::INT_TINY, "default" => 1, "comment" => "状态 1创建 2同意 3拒绝"])
            ->addColumn("user_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => true, "comment" => "审核人id"])
            ->addColumn("audit_time", "timestamp", ["null" => true, "comment" => "审核时间"])
            ->addColumn("reason", "string", ["limit" => MysqlAdapter::INT_TINY, "null" => true, "comment" => "拒绝原因"])
            ->addTimestamps()
            ->save();
    }
}
