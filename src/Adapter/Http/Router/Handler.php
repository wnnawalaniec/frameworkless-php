<?php
declare(strict_types=1);

namespace App\Adapter\Http\Router;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface for route handler which is executed after request is matched with route. This
 * basically should execute application logic with data from request and return HTTP response back.
 */
interface Handler
{
    public function call(RequestInterface $request, ResponseInterface $response, array $params = []): ResponseInterface;
}