<?php
require_once __DIR__ . "/../../bootstrap/bootstrap.php";

while (true) {
    $job = di("queue")->watch("SmsCode")->reserve();
    $data = unserialize($job->getData());
    $smsCode = $data['smsCode'];
    $token = $data['token'];
    //业务逻辑
    service("sms/manager")->send($smsCode, $token);
    di("cache")->delete($token . "_tcgmc");
    $job->delete();
}

