<?php
require_once __DIR__ . "/../../bootstrap/bootstrap.php";

$smsCode = \Ddb\Modules\SmsCode::findFirst();

$job = di("queue")->useTube("SmsCode")->put(123123123);



