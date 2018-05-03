<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-3
 * Time: 上午11:00
 * 查看目前job所有的状态
 */
require __DIR__ . '/../../bootstrap/bootstrap.php';
use Pheanstalk\Pheanstalk;
$pheanstalk = new Pheanstalk("127.0.0.1",11300);
print_r($pheanstalk->statsTube("default"));

//ready bury delay reserve

//status
/**
[current-jobs-urgent] => 0
[current-jobs-ready] => 0
[current-jobs-reserved] => 0
[current-jobs-delayed] => 0 延迟
[current-jobs-buried] => 0 预留
[cmd-put] => 1 累计运行
[cmd-peek] => 0
[cmd-peek-ready] => 3
[cmd-peek-delayed] => 0
[cmd-peek-buried] => 0
[cmd-reserve] => 0
[cmd-reserve-with-timeout] => 0
[cmd-delete] => 1
[cmd-release] => 0
[cmd-use] => 0
[cmd-watch] => 0
[cmd-ignore] => 0
[cmd-bury] => 0
[cmd-kick] => 0
[cmd-touch] => 0
[cmd-stats] => 1
[cmd-stats-job] => 0
[cmd-stats-tube] => 0
[cmd-list-tubes] => 0
[cmd-list-tube-used] => 0
[cmd-list-tubes-watched] => 0
[cmd-pause-tube] => 0
[job-timeouts] => 0 任务超时次数
[total-jobs] => 1 任务累计数量
[max-job-size] => 65535 字节大小小智
[current-tubes] => 1 当前管道输
[current-connections] => 1 当前连接数
[current-producers] => 0
[current-workers] => 0
[current-waiting] => 0 发出reserve指令,但是一直未处理
[total-connections] => 4 累计连接数
[pid] => 1024 进程id
[version] => 1.10
[rusage-utime] => 0.000000 进程执行用户代码时间
[rusage-stime] => 0.002809 进程执行内核代码的时间 反应beanstalk负载情况 不能抄错1秒
[uptime] => 9019
[binlog-oldest-index] => 0
[binlog-current-index] => 0
[binlog-records-migrated] => 0
[binlog-records-written] => 0
[binlog-max-size] => 10485760
[id] => 05d75a6ca5aae2c2
[hostname] => lsw

 */

//statusTube
/**
 * [name] => default
[current-jobs-urgent] => 0
[current-jobs-ready] => 0
[current-jobs-reserved] => 0
[current-jobs-delayed] => 0
[current-jobs-buried] => 0
[total-jobs] => 1
[current-using] => 1 当前多少个生产者正在用这个管道 生产者用userTube时
[current-watching] => 1 当前有多少个消费者在使用这个管道 消费者使用watch管道时加1
[current-waiting] => 0 当前多少消费这等待任务到来
[cmd-delete] => 1
[cmd-pause-tube] => 0
[pause] => 0
[pause-time-left] => 0
 */

//useTube 使用哪个管道

//statsJob

//reserve会去除ready状态的任务

//peek 根据任务id获取任务的状态


//生产类
/**
 * putInTube
 * $pheanstalk->putInTube("newUsers",6666)
 *
 * put
 * $pheanstalk->useTube("newUsers")->put("666")
 */

//消费类
/**
 * watch
 *
 * reserve阻塞方式进行监听 reserve(3)阻塞3秒
 *
 * release方法 可以设置优先级 和延迟
 * $pheanstalk->release($job,优先级)
 */