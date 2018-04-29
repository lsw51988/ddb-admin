<?php

namespace Dowedo\Jobs;

use Ddb\Core\Job;

class SendSms extends Job
{
    public function run($data, &$log)
    {
        // $log 记录的是任务本身执行的行为：进程信息
        // 调用过程的日志使用 logger 服务记录
        $id = (int) $data;
        try {
            $result = service('sms/sender')->send($id);
            if ($result) {
                $log[] = "短信发送成功，信息ID=$id";
            } else {
                $log[] = "短信发送失败，等待重试信息ID=$id";
            }
        } catch (\Exception $e) {
            $log[] = "短信发送异常：" . $e->getMessage();
        }

        // 无论发送成功与否，都返回true，表示本任务处理过了。
        return true;
    }


}
