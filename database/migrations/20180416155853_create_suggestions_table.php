<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateSuggestionsTable extends AbstractMigration
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
        $this->table("suggestions")
            ->addColumn("member_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => false, "comment" => "关联member"])
            ->addColumn("content", "string", ["limit" => MysqlAdapter::INT_TINY, "null" => false, "comment" => "建议"])
            ->addColumn("type", "integer", ["limit" => MysqlAdapter::INT_TINY, "null" => false, "comment" => "类别"])
            ->addColumn("user_id", "integer", ["limit" => MysqlAdapter::INT_SMALL, "null" => true, "comment" => "审核人"])
            ->addColumn("refuse_reason", "string", ["limit" => MysqlAdapter::INT_TINY, "null" => true, "comment" => "拒绝原因"])
            ->addColumn("reply", "string", ["limit" => MysqlAdapter::INT_TINY, "null" => true, "comment" => "采纳情况下的回复"])
            ->addColumn("status", "integer", ["limit" => 10, "null" => true, "comment" => "状态 1提交 2否决 3采纳"])
            ->addColumn("audit_time", "timestamp", ["null" => true, "comment" => "审核时间"])
            ->addTimestamps()
            ->save();
    }
}
