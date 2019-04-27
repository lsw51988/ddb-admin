<?php

namespace Ddb\Service\Queue;


use Ddb\Core\Service;
use Phalcon\Exception;

class Manager extends Service
{
    /**
     * @param $queue
     * @param $data
     * @param int $delay
     * @return mixed
     * @throws Exception
     */
    public function queue($queue, $data, $delay = 0)
    {
        try {
            // use tube
            di('queue')->choose($queue);
            return di('queue')->put($data, ['delay' => $delay]);
        } catch (\Exception $e) {
            throw new Exception('queue failed', 500, $e);
        }
    }
}
