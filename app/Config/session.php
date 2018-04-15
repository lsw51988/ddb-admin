<?php
return [
    'local'=>[
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
            'host' => 'localhost', // 只有生产上才会使用session服务器 10.253.5.136 为生产环境的session服务器地址
            'auth' => "", // 需要redis服务器配置密码
            'port' => 6379,
            'lifetime' => 14400,
            'persistent' => false,
            'prefix' => '_SESSION_',
        ],
    ],
    'qa'=>[
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
            'host' => 'localhost', // 只有生产上才会使用session服务器 10.253.5.136 为生产环境的session服务器地址
            'auth' => "", // 需要redis服务器配置密码
            'port' => 6379,
            'lifetime' => 14400,
            'persistent' => false,
            'prefix' => '_SESSION_',
        ],
    ],
    'production'=>[
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
            'host' => 'localhost', // 只有生产上才会使用session服务器 10.253.5.136 为生产环境的session服务器地址
            'auth' => "", // 需要redis服务器配置密码
            'port' => 6379,
            'lifetime' => 14400,
            'persistent' => false,
            'prefix' => '_SESSION_',
        ],
    ]

];
