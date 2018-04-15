<?php

return [
    'local' => [
        'root' => APP_PATH . '/../storage/images'
    ],

    'qa' => [
        'Bucket' => 'xmn-qa',
        'Endpoint' => 'http://oss-cn-shanghai-internal.aliyuncs.com',
        'AccessKeyId' => 'LTAIdXCxPqc98wab',
        'AccessKeySecret' => 'M8FwfKZQ2KEbWL0XIfZf3uXEEd2ZAH'
    ],

    'production' => [
        'Bucket' => 'xmn',
        'Endpoint' => 'http://oss-cn-shanghai-internal.aliyuncs.com',
        'AccessKeyId' => 'LTAIdXCxPqc98wab',
        'AccessKeySecret' => 'M8FwfKZQ2KEbWL0XIfZf3uXEEd2ZAH'
    ]
];
