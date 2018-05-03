<?php

namespace PHPSTORM_META {
    /**
     * phpstorm自带代码寻址提示
     */
    $STATIC_METHOD_TYPES = [
        \service('') => [
            '' == '@',
            'member/query' instanceof \Ddb\Service\Member\Query,
            'member/manager' instanceof \Ddb\Service\Member\Manager,
            'appeal/query' instanceof \Ddb\Service\Appeal\Query,
            'sms/manager' instanceof \Ddb\Service\Sms\Manager,
            'queue/manager' instanceof \Ddb\Service\Queue\Manager,
        ]
    ];
}