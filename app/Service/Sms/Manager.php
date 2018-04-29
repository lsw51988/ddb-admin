<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-29
 * Time: 下午2:48
 */

namespace Ddb\Service\Sms;
use Ddb\Core\Service;

class Manager extends Service
{
    public function send($id){
        $smsMessage = SmsMessage::findFirst($id);
        if (!$smsMessage) {
            throw new ResourceNotFoundException("No Such Message: id=$id");
        }
    }
}