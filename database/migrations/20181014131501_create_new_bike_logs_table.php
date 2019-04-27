<?php


use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class CreateNewBikeLogsTable extends AbstractMigration
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
    //新车用户操作日志
    public function change()
    {
        $this->table("new_bike_logs")
            ->addColumn("new_bike_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR])
            ->addColumn("content", "string", ["limit" => 60, "comment" => "用户操作内容"])
            ->addTimestamps()
            ->save();
    }
}
