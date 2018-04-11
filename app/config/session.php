<?php
return [
    'session_name' => 'DDB_SESSION_ID',
    'cookie_params' => [
        'lifetime' => 3600 * 24 * 30,
        'path' => '/',
        'domain' => null,
        'secure' => false,
        'encrypt' => false,
    ],

    // adapter config
    'options' => [
        'uniqueId' => 'DDB_SESSION_',
        'host' => env("REDIS_HOST", app_env() == 'production' ? "a13a0ec97fdd4f7c.m.cnhza.kvstore.aliyuncs.com" : "12b16ef631fa4d83.m.cnhza.kvstore.aliyuncs.com"), // 只有生产上才会使用session服务器 10.253.5.136 为生产环境的session服务器地址
        'auth' => env("REDIS_PASS", app_env() == 'production' ? 'a13a0ec97fdd4f7c:Dowedo654321' : "12b16ef631fa4d83:Dowedo654321"), // 需要redis服务器配置requirepass
        'port' => env("REDIS_PORT", 6379),
        'lifetime' => 14400,
        'persistent' => false,
        'prefix' => '_SESSION_',
    ],
];
