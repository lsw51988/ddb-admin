<?php

namespace Ddb\Core;

use Ddb\Models\Accesses;;

/**
 * Class Job
 * @package Ddb\Core
 */
abstract class Job extends \Phalcon\Queue\Beanstalk\Job
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
        $data['id']=1;
        $data['parent_id']=1;
        $data['access_id']=1;
        $data['model_id']=1;
        $access = new Accesses();
        $access->save($data);
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
