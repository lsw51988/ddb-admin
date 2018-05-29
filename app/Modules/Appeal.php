<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-12
 * Time: 下午2:39
 */

namespace Ddb\Modules;

use Ddb\Models\Appeals;

class Appeal extends Appeals
{
    const TYPE_BLOWOUT = 0;
    const TYPE_LEAK = 1;
    const TYPE_MOTOR_BREAK = 2;
    const TYPE_POWER_OFF = 3;
    const TYPE_NOT_START = 4;
    const TYPE_LOCK_BROKE = 5;
    const TYPE_BAD_CONTACT = 6;
    const TYPE_OTHER = 99;
    public static $typeDesc = [
        self::TYPE_BLOWOUT => "爆胎",
        self::TYPE_LEAK => "漏气",
        self::TYPE_NOT_START => "无法启动",
        self::TYPE_LOCK_BROKE => "锁坏了",
        self::TYPE_BAD_CONTACT => "接触不良",
        self::TYPE_OTHER => "其他",
    ];

    const METHOD_SHOW = 1;
    const METHOD_SOS = 2;
    public static $methodDesc = [
        self::METHOD_SHOW => "查看附近维修点",
        self::METHOD_SOS => "无法移动,寻求帮助"
    ];

    const STATUS_CREATE = 1;
    const STATUS_CANCEL = 2;
    const STATUS_OUT_DATE = 3;
    const STATUS_ANSWER = 4;
    const STATUS_FINISH = 5;
    public static $statusDesc = [
        self::STATUS_CREATE => "创建",
        self::STATUS_CANCEL => "用户取消",
        self::STATUS_OUT_DATE => "过期自动取消",
        self::STATUS_ANSWER => "修理者应答",
        self::STATUS_FINISH => "请求完成"
    ];
}