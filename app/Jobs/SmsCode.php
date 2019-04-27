<?php
require_once __DIR__ . "/../../bootstrap/bootstrap.php";

while (true) {
    $job = di("queue")->watch("SmsCode")->reserve();
    $data = unserialize($job->getData());
    $smsCodeId = $data['smsCodeId'];
    $token = $data['token'];
    $data = $data['data'];
    //业务逻辑
    if (service("sms/manager")->send($smsCodeId, $token,$data)) {
        di("queue")->delete($job);
    } else {
        di("queue")->bury($job, 10240);
    }
    if($token!=null){
        di("cache")->delete($token . "_tcgmc");
    }
}

