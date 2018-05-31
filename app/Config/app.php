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
        'APP_ID'=>'wx3bd752036e968963',
        'APP_SECRET'=>'2b8e86b02fae128e93099f3549faacb6',
        'URL'=>'http://local.ddb.com'
    ],
    'qa'=>[
        "cryptKey"=>"lsw20180414<>_~@#$%&^",
        // 日志配置
        'log_path'  => APP_PATH . '/../storage/logs',
        'debug' => true,
        'tecent_addr_key'=>'6MSBZ-F25WU-GW7VT-BDDKI-XV2WT-JNF37',
        'APP_ID'=>'wx3bd752036e968963',
        'APP_SECRET'=>'2b8e86b02fae128e93099f3549faacb6',
        'URL'=>'http://www.ebikea.com'
    ],
    'production'=>[
        "cryptKey"=>"lsw20180414<>_~@#$%&^",
        // 日志配置
        'log_path'  => APP_PATH . '/../storage/logs',
        'debug' => true,
        'tecent_addr_key'=>'6MSBZ-F25WU-GW7VT-BDDKI-XV2WT-JNF37',
        'APP_ID'=>'wx3bd752036e968963',
        'APP_SECRET'=>'2b8e86b02fae128e93099f3549faacb6',
        'URL'=>'http://www.njddb.com'
    ]

];