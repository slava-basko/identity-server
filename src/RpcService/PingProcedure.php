<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\RpcService;

use Is\Sdk\Service\Interfaces\PingService;

class PingProcedure implements PingService
{
    /**
     * @return string
     */
    public function ping()
    {
        return 'pong';
    }
}
