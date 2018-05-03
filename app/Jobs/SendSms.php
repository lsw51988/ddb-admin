<?php
require_once __DIR__."/../../bootstrap/bootstrap.php";
use Ddb\Models\SmsCodes;
//$pheanstalk = new \Pheanstalk\Pheanstalk('localhost',11300);
while(true){
    $job = di("queue")->watch("SendSms")->reserve();
    $data = $job->getData();
    //业务逻辑



    $job->delete();
}

