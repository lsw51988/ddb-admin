<?php

namespace PHPSTORM_META {

    /**
     * PhpStorm Meta file, to provide autocomplete information for PhpStorm
     * Generated on 2016-10-21 10:26:57
     */
    $STATIC_METHOD_TYPES = [
        \di('') => [
            '' == '@',
            'session' instanceof \Phalcon\Session\Adapter\Files,
        ],
        \service('') => [
            '' == '@',
            'appeal/query' instanceof \Ddb\Service\Appeal\Query,
            'file/manager' instanceof \Ddb\Service\File\Manager,
            'member/query' instanceof \Ddb\Service\Member\Query,
            'member/manager' instanceof \Ddb\Service\Member\Manager,
            'point/manager' instanceof \Ddb\Service\Point\Manager,
            'queue/manager' instanceof \Ddb\Service\Queue\Manager,
            'repair/query' instanceof \Ddb\Service\Repair\Query,
            'sms/manager' instanceof \Ddb\Service\Sms\Manager,
            'shb/query' instanceof \Ddb\Service\Shb\Manager,
            'user/manager' instanceof \Ddb\Service\User\Manager,
            'user/query' instanceof \Ddb\Service\User\Query,
        ]
    ];
}