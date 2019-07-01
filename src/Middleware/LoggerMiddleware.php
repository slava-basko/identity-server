<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Middleware;

use Monolog\Logger;
use SimpleBus\Message\Bus\Middleware\MessageBusMiddleware;

class LoggerMiddleware implements MessageBusMiddleware
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * LoggerMiddleware constructor.
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param object $command
     * @param callable $next
     */
    public function handle($command, callable $next)
    {
        $next($command);
    }
}
