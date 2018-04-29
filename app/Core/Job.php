<?php

namespace Ddb\Core;


/**
 * Class Job
 * @package Ddb\Core
 */
abstract class Job
{
    /**
     *
     */
    public function init()
    {

    }

    /**
     * @param $log
     */
    public function beforeRun(&$log)
    {
        $log[] = get_class($this) . "::beforeRun() called";
    }

    /**
     * @param $data
     * @param $log
     * @return mixed
     */
    abstract public function run($data, &$log);

    /**
     * @param $log
     */
    public function afterRun(&$log)
    {
        $log[] = get_class($this) . "::afterRun() called";
    }

} // End Job
