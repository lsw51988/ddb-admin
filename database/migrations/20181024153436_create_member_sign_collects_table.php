<?php


use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class CreateMemberSignCollectsTable extends AbstractMigration
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
        $this->table("member_sign_collects")
            ->addColumn("member_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => false, "comment" => "用户id"])
            ->addColumn("week_count", "integer", ["limit" => MysqlAdapter::INT_TINY, "null" => false, "comment" => "本周签到次数"])
            ->addColumn("month_count", "integer", ["limit" => MysqlAdapter::INT_TINY, "null" => false, "comment" => "本月签到次数"])
            ->addColumn("continue_count", "integer", ["limit" => MysqlAdapter::INT_TINY, "null" => false, "comment" => "持续签到次数，断一次则归0"])
            ->addColumn("count", "integer", ["limit" => MysqlAdapter::INT_SMALL, "null" => false, "comment" => "总签到次数"])
            ->addTimestamps()
            ->save();
    }
}
