<?php


use Phinx\Migration\AbstractMigration;

class CreateSmsCodesTable extends AbstractMigration
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
        $this->table("sms_codes")
            ->addColumn("mobile", "string", ["limit" => 11])
            ->addColumn("code", "string", ["limit" => 10])
            ->addColumn("template", "string", ["limit" => 30, "comment" => "模板"])
            ->addColumn("status", "integer", ["limit" => 10, "comment" => "状态 1发送中 2发送成功 3发送失败", "default" => 1])
            ->addColumn("memo", "string", ["limit" => 30, "comment" => "回调", "null" => true])
            ->addTimestamps()
            ->save();
    }
}
