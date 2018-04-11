<?php
return [
    'development' => [
        'db' => [
            'host' => env('DATABASE_HOST', 'localhost'),
            'dbname' => env('DATABASE_NAME', 'ddb'),
            'username' => env('DATABASE_USER', 'lsw'),
            'password' => env('DATABASE_PASS', 'lsw51988'),
            'charset' => 'utf8',
            'persistent' => false,
            'options' => []
        ]
    ],
    'production' => [
        'db' => [
            'host' => env('DATABASE_HOST', 'localhost'),
            'dbname' => env('DATABASE_NAME', 'ddb'),
            'username' => env('DATABASE_USER', 'lsw'),
            'password' => env('DATABASE_PASS', 'lsw51988'),
            'charset' => 'utf8',
            'persistent' => false,
            'options' => []
        ]
    ],

    'modelsMetaData' => [
        'metaDataDir' => __DIR__ . '/../storage/framework/metaData'
    ],

    'models' => [
        "cacheDir" => __DIR__ . '/../storage/framework/models',
        "prefix" => "ddb-cache-data-"
    ],
];
