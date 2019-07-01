<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Http;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Zend\Json\Server\Response;

class JsonResponse extends SymfonyResponse
{
    private static $defaultHeader = [
        'Content-Type' => 'application/json',
    ];

    /**
     * @param Response $response
     * @return static
     */
    public static function fromZendResponse(Response $response, LoggerInterface $logger)
    {
        $response = $response->toJson();
        $logger->info($response);
        return new static($response, 200, self::$defaultHeader);
    }
}