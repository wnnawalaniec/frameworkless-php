<?php
declare(strict_types=1);

namespace App\Adapter\Http;

use App\Adapter\Http\Router\Exception\RouteNotFound;
use App\Adapter\Http\Router\Handler;
use App\Adapter\Http\Router\ResolvedRoute;
use Psr\Http\Message\RequestInterface;

/**
 * Interface for HTTP routing mechanism. It maps HTTP method and request URI to proper handler
 * executing desired application logic.
 */
interface Router
{
    /**
     * @throws RouteNotFound
     */
    public function dispatch(RequestInterface $request): ResolvedRoute;

    /**
     * @param string $method
     * @param string $route
     * @param Handler $handler
     * @return void
     */
    public function add(string $method, string $route, Handler $handler): void;

    /**
     * @param string $route
     * @param Handler $handler
     * @return void
     */
    public function get(string $route, Handler $handler): void;

    /**
     * @param string $route
     * @param Handler $handler
     * @return void
     */
    public function post(string $route, Handler $handler): void;

    /**
     * @param string $route
     * @param Handler $handler
     * @return void
     */
    public function delete(string $route, Handler $handler): void;

    /**
     * @param string $route
     * @param Handler $handler
     * @return void
     */
    public function put(string $route, Handler $handler): void;
}