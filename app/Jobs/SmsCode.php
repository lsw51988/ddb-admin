<?php
require_once __DIR__ . "/../../bootstrap/bootstrap.php";

while (true) {
    app_log("queue")->info();
    $job = di("queue")->watch("SmsCode")->reserve();
    $data = unserialize($job->getData());
    $smsCodeId = $data['smsCodeId'];
    $token = $data['token'];
    //业务逻辑
    if (service("sms/manager")->send($smsCodeId, $token)) {
        di("queue")->delete($job);
    } else {
        di("queue")->bury($job, 10240);
    }
    if($token!=null){
        di("cache")->delete($token . "_tcgmc");
    }
}

