<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-18
 * Time: 下午11:44
 */

namespace Ddb\Service;


use Ddb\Core\Service;

class BaseService extends Service
{
    //单利模式
    private static $instance = null;

    public static function getInstance()
    {
        $className = get_called_class();
        if (is_null(self::$instance)) {
            self::$instance = new $className;
        }
        return self::$instance;
    }
}