<?php
/**
 * 视图的相关配置
 */
return [
    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'path' => __DIR__ . '/../views',

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */
    'lifetime' => 86400,
    'compiled' => __DIR__ . '/../../storage/framework/views',

    /*
    |--------------------------------------------------------------------------
    | Volt Engine Setting
    |--------------------------------------------------------------------------
    | 模板引擎的配置
    |
    */

    'volt' => [
        'compiledPath' => __DIR__ . '/../../storage/framework/volts/',
        'compiledSeparator' => '_',
        'compileAlways' => false,
        'autoescape' => true
    ],
];
