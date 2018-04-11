<?php

use Phinx\Seed\AbstractSeed;

class ProvinceSeeder extends AbstractSeed
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
        $data = array(
            array('100000', '全国'),
            array('110000', '北京市'),
            array('120000', '天津市'),
            array('130000', '河北省'),
            array('140000', '山西省'),
            array('150000', '内蒙古自治区'),
            array('210000', '辽宁省'),
            array('220000', '吉林省'),
            array('230000', '黑龙江省'),
            array('310000', '上海市'),
            array('320000', '江苏省'),
            array('330000', '浙江省'),
            array('340000', '安徽省'),
            array('350000', '福建省'),
            array('360000', '江西省'),
            array('370000', '山东省'),
            array('410000', '河南省'),
            array('420000', '湖北省'),
            array('430000', '湖南省'),
            array('440000', '广东省'),
            array('450000', '广西壮族自治区'),
            array('460000', '海南省'),
            array('500000', '重庆市'),
            array('510000', '四川省'),
            array('520000', '贵州省'),
            array('530000', '云南省'),
            array('540000', '西藏自治区'),
            array('610000', '陕西省'),
            array('620000', '甘肃省'),
            array('630000', '青海省'),
            array('640000', '宁夏回族自治区'),
            array('650000', '新疆维吾尔自治区'),
            array('710000', '台湾省'),
            array('810000', '香港特别行政区'),
            array('820000', '澳门特别行政区'),
            array('910000', '其它')
        );
        $arr = array();
        foreach ($data as $key => $items) {
            $arr[] = array('code' => $items[0], 'name' => $items[1]);
        }
        foreach ($arr as $key => $items) {
            $sql = "select * from provinces where code = '$items[code]'";
            $query = $this->fetchRow($sql);
            if (empty($query)) {
                $item_arr = array('0' => $items);
                $posts = $this->table('provinces');
                $posts->insert($item_arr)
                    ->save();
            }
        }
    }
}
