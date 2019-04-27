<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateOrdersTable extends AbstractMigration
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
    //积分订单
    public function change()
    {
        $this->table("orders")
            ->addColumn("member_id", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => false, "comment" => "member关联"])
            ->addColumn("device_info", "string", ["limit" => 32, "null" => true, "comment" => "设备号,自定义参数，可以为终端设备号(门店号或收银设备ID)，PC网页或公众号内支付可以传\"WEB\""])
            ->addColumn("nonce_str", "string", ["limit" => 32, "null" => false, "comment" => "随机字符串"])
            ->addColumn("sign", "string", ["limit" => 32, "null" => false, "comment" => "签名"])
            ->addColumn("sign_type", "string", ["limit" => 20, "default" => "MD5", "comment" => "签名类型"])
            ->addColumn("body", "string", ["limit" => 40, "null" => false, "comment" => "商品描述"])
            ->addColumn("detail", "string", ["limit" => 100, "null" => true, "comment" => "商品详情"])
            ->addColumn("attach", "string", ["limit" => 100, "null" => true, "comment" => "附加数据"])
            ->addColumn("out_trade_no", "string", ["limit" => 32, "null" => false, "comment" => "订单号"])
            ->addColumn("total_fee", "integer", ["limit" => MysqlAdapter::INT_REGULAR, "null" => false, "comment" => "充值金额,单位分"])
            ->addColumn("spbill_create_ip", "string", ["limit" => 40, "null" => false, "comment" => "终端IP"])
            ->addColumn("trade_type", "string", ["limit" => 20, "default" => "JSAPI", "comment" => "交易类型默认小程序"])
            ->addColumn("openid", "string", ["limit" => 40, "null" => false, "comment" => "用户在商户appid下的唯一标识"])
            ->addColumn("return_code", "string", ["limit" => 16, "null" => true, "comment" => "返回状态码"])
            ->addColumn("return_msg", "string", ["limit" => 100, "null" => true, "comment" => "返回信息"])
            ->addColumn("result_code", "string", ["limit" => 16, "null" => true, "comment" => "错误代码"])
            ->addColumn("err_code", "string", ["limit" => 32, "null" => true, "comment" => "错误代码"])
            ->addColumn("err_code_des", "string", ["limit" => 60, "null" => true, "comment" => "错误代码描述"])
            ->addColumn("prepay_id", "string", ["limit" => 60, "null" => true, "comment" => "预支付交易会话标识"])
            ->addColumn("finish_time", "timestamp", ["comment" => "用户支付时间", "null" => true])
            ->addTimestamps()
            ->save();
    }
}
