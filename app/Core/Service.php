<?php
/**
 * Created by PhpStorm.
 * User: Xueron
 * Date: 2015/7/30
 * Time: 11:25
 */

namespace Ddb\Core;

use Phalcon\Di\Injectable;

/**
 * Class Service
 * @package Ddb\Core\Service
 * @property \Phalcon\Logger\Adapter\File|\Phalcon\Logger\AdapterInterface $logger
 * @property \Phalcon\Queue\Beanstalk $queue
 */
abstract class Service extends Injectable
{

}
