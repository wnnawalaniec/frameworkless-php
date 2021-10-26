<?php
declare(strict_types=1);

namespace App\Adapter\Http\Helper;

use Psr\Http\Message\ResponseInterface;

/**
 * Class with static methods helping in some common HTTP based
 * actions involving responses.
 */
class ResponseHelper
{
    /**
     * @param ResponseInterface $response
     * @param mixed $body
     * @return ResponseInterface
     */
    public static function json(ResponseInterface $response, $body = []): ResponseInterface
    {
        $response = $response->withAddedHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode($body));
        return $response;
    }
}