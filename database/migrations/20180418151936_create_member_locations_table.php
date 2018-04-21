<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateMemberLocationsTable extends AbstractMigration
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
    //用户经常出现的位置
    public function change()
    {
        $this->table("member_locations")
            ->addColumn("member_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "comment" => "关联members"])
            ->addColumn("latitude", "string", ["comment" => "纬度", "limit" => 10])
            ->addColumn("longitude", "string", ["comment" => "经度", "limit" => 10])
            ->addColumn("address", "string", ["comment" => "地址", "limit" => 60])
            ->addColumn("province", "string", ["comment" => "省", "limit" => 20])
            ->addColumn("city", "string", ["comment" => "市", "limit" => 20])
            ->addColumn("district", "string", ["comment" => "区", "limit" => 20])
            ->addColumn("street", "string", ["comment" => "街道", "limit" => 20])
            ->addColumn("street_number", "string", ["comment" => "街道名称", "limit" => 20])
            ->addTimestamps()
            ->save();
    }
}
