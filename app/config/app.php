<?php
return [
    // ���Կ���
    'debug' => true,


    // ��־����
    'log' => [
        'path' => __DIR__ . '/../../storage/logs',
    ],

    'pdf' => array(
        'path' => __DIR__ . '/../storage/pdf',
    ),

    // ����У�������Կ
    'checkCodeSalt' => 'RYDCHECKCODESALT',

    // ���ݿ�͸�������õ���key
    'cryptKey' => 'DOWEDO@CRYPT#KEY',

    // ��ҳ���ã�ÿҳ��ʾ��Ŀ������Ĭ��ֵ
    'pageSize' => 15,

    // ������֤�����Чʱ��
    'smsCodeTtl' => 300,
];