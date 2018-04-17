<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateSecondBikeImagesTable extends AbstractMigration
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
        $this->table("second_bike_images")
            ->addColumn("second_bike_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => false, "comment" => "关联second_bikes"])
            ->addColumn("path", "string", ["limit" => MysqlAdapter::INT_TINY,"null" => false,  "comment" => "存储时间"])
            ->addColumn("create_by", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => false, "comment" => "对应member"])
            ->addTimestamps()
            ->save();
    }
}
