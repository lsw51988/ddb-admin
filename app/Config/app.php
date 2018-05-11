<?php
/**
 * Created by PhpStorm.
 * User: 阿德
 * Date: 2018/4/14
 * Time: 23:04
 */
return [
    'local'=>[
        "cryptKey"=>"lsw20180414<>_~@#$%&^",
        // 日志配置
        'log_path'  => APP_PATH . '/../storage/logs',
        'debug' => true,
        //获取地理位置信息的
        'tecent_addr_key'=>'6MSBZ-F25WU-GW7VT-BDDKI-XV2WT-JNF37',
        //获取openid的
        'APP_ID'=>'wxb029435696312911',
        'APP_SECRET'=>'b2237b984a982ba9de8f3a7fe5f78813',
        'URL'=>'http://local.ddb.com'

    ],
    'qa'=>[
        "cryptKey"=>"lsw20180414<>_~@#$%&^",
        // 日志配置
        'log_path'  => APP_PATH . '/../storage/logs',
        'debug' => true,
        'tecent_addr_key'=>'6MSBZ-F25WU-GW7VT-BDDKI-XV2WT-JNF37',
        'APP_ID'=>'wxb029435696312911',
        'APP_SECRET'=>'b2237b984a982ba9de8f3a7fe5f78813',
        'URL'=>'http://www.qa-njddb.com'
    ],
    'production'=>[
        "cryptKey"=>"lsw20180414<>_~@#$%&^",
        // 日志配置
        'log_path'  => APP_PATH . '/../storage/logs',
        'debug' => true,
        'tecent_addr_key'=>'6MSBZ-F25WU-GW7VT-BDDKI-XV2WT-JNF37',
        'APP_ID'=>'wxb029435696312911',
        'APP_SECRET'=>'b2237b984a982ba9de8f3a7fe5f78813',
        'URL'=>'http://www.njddb.com'
    ]

];