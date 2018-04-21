<?php


use Phinx\Migration\AbstractMigration;

class CreateAreasTable extends AbstractMigration
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
        $this->table("areas")
            ->addColumn("district_code", "string", ["limit" => 20])
            ->addColumn("district_name", "string", ["limit" => 20])
            ->addColumn("city_code", "string", ["limit" => 20])
            ->addColumn("city_name", "string", ["limit" => 20])
            ->addColumn("province_code", "string", ["limit" => 20])
            ->addColumn("province_name", "string", ["limit" => 20])
            ->save();
    }
}
