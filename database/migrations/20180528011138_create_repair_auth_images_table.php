<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateRepairAuthImagesTable extends AbstractMigration
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
        $this->table("repair_auth_images")
            ->addColumn("repair_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => false, "comment" => "repairs"])
            ->addColumn("path", "string", ["limit" => MysqlAdapter::INT_TINY, "null" => false, "comment" => "存储路径"])
            ->addColumn("size", "integer", ["limit" => MysqlAdapter::INT_MEDIUM, "null" => false, "comment" => "大小"])
            ->addColumn("create_by", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => false, "comment" => "上传人id"])
            ->addTimestamps()
            ->save();
    }
}
