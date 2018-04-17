<?php

use Phinx\Seed\AbstractSeed;

class ZZDistrictsSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $this->query("truncate table districts;
        insert into districts(district_code,district_name,city_code,city_name,province_code,province_name)
        select d.code,d.name,c.code,c.name,p.code,p.name from districts d left join cities c on d.city_code = c.code 
        left join provinces p on c.province_code = p.code");
    }
}
