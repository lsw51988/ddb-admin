<?php
return [
    // 调试开关
    'debug' => true,


    // 日志配置
    'log' => [
        'path' => __DIR__ . '/../../storage/logs',
    ],

    'pdf' => array(
        'path' => __DIR__ . '/../storage/pdf',
    ),

    // 计算校验码的密钥
    'checkCodeSalt' => 'RYDCHECKCODESALT',

    // 数据库透明加密用到的key
    'cryptKey' => 'DOWEDO@CRYPT#KEY',

    // 分页设置，每页显示条目数量，默认值
    'pageSize' => 15,

    // 短信验证码最长有效时间
    'smsCodeTtl' => 300,
];