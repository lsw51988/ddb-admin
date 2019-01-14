<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateRepairsTable extends AbstractMigration
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
        $this->table("repairs")
            ->addColumn("name", "string", ["limit" => 20, "null" => false, "comment" => "名称"])
            ->addColumn("belonger_name", "string", ["limit" => 20, "null" => false, "comment" => "店主姓名或姓氏"])
            ->addColumn("type", "integer", ["limit" => 20, "default" => 0, "comment" => "类型 0电动车维修点 1电动车维修兼销售点 2便民开锁点"])
            ->addColumn("longitude", "string", ["limit" => 10, "null" => false, "comment" => "经度"])
            ->addColumn("latitude", "string", ["limit" => 10, "null" => false, "comment" => "纬度"])
            ->addColumn("province", "string", ["comment" => "所在省", "limit" => 6, "null" => false])
            ->addColumn("city", "string", ["comment" => "所在市", "limit" => 6, "null" => false])
            ->addColumn("district", "string", ["comment" => "所在区", "limit" => 6, "null" => false])
            ->addColumn("address", "string", ["limit" => 60, "null" => false, "comment" => "详细街道地址"])
            ->addColumn("mobile", "string", ["limit" => 11, "default" => '', "comment" => "手机号码"])
            ->addColumn("remark", "string", ["limit" => 60, "null" => true, "comment" => "备注,更好辨识地址"])
            ->addColumn("create_by", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => false, "comment" => "创建人id"])
            ->addColumn("create_by_type", "integer", ["limit" => MysqlAdapter::INT_TINY, "default" => 1, "comment" => "创建人类型 1member 2user"])
            ->addColumn("belonger_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => true, "comment" => "归属者"])
            ->addColumn("auditor_id", "integer", ["limit" => MysqlAdapter::INT_SMALL, "null" => true, "comment" => "后台审核者 对应user"])
            ->addColumn("status", "integer", ["limit" => MysqlAdapter::INT_TINY, "default" => 1, "comment" => "状态 1被创建 2后台审核通过 3后台审核拒绝"])
            ->addColumn("refuse_reason", "string", ["limit" => MysqlAdapter::INT_TINY, "null" => true, "comment" => "审核不通过原因"])
            ->addTimestamps()
            ->save();
    }
}
