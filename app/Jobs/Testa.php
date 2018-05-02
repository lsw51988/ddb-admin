<?php


use Ddb\Models\Accesses;

class Testa extends \Phalcon\Queue\Beanstalk\Job
{
    public function run($data, &$log)
    {
        // $log 记录的是任务本身执行的行为：进程信息
        // 调用过程的日志使用 logger 服务记录
        $data['id']=1;
        $data['parent_id']=1;
        $data['access_id']=1;
        $data['model_id']=1;
        $access = new Accesses();
        $access->save($data);
        return true;
    }


}