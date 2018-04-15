<?php
/**
 * 视图的相关配置
 */
return [
    'local'=>[
        'path' => APP_PATH . '/views',
        'lifetime' => 86400,
        'compiled' => APP_PATH . '/../storage/framework/views',
        'volt' => [
            'compiledPath' => APP_PATH . '/../storage/framework/volts/',
            'compiledSeparator' => '_',
            'compileAlways' => false,
            'autoescape' => true
        ],
    ],
    'qa'=>[
        'path' => APP_PATH . '/views',
        'lifetime' => 86400,
        'compiled' => APP_PATH . '/../storage/framework/views',
        'volt' => [
            'compiledPath' => APP_PATH . '/../storage/framework/volts/',
            'compiledSeparator' => '_',
            'compileAlways' => false,
            'autoescape' => true
        ],
    ],
    'production'=>[
        'path' => APP_PATH . '/views',
        'lifetime' => 86400,
        'compiled' => APP_PATH . '/../storage/framework/views',
        'volt' => [
            'compiledPath' => APP_PATH . '/../storage/framework/volts/',
            'compiledSeparator' => '_',
            'compileAlways' => false,
            'autoescape' => true
        ],
    ]

];
