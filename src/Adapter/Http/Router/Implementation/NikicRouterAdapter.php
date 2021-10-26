<?php
declare(strict_types=1);

namespace App\Adapter\Http\Router\Implementation;

use App\Adapter\Http\Router;
use App\Adapter\Http\Router\ResolvedRoute;
use FastRoute\Dispatcher;
use FastRoute\Dispatcher\GroupCountBased;
use FastRoute\RouteCollector;
use Psr\Http\Message\RequestInterface;

/**
 * Example of Router implementation adapting some well-known, 3-rd party library.
 */
class NikicRouterAdapter implements Router
{
    /**
     * @param RouteCollector $routeCollector
     */
    public function __construct(RouteCollector $routeCollector)
    {
        $this->routeCollector = $routeCollector;
    }

    /**
     * @inheritDoc
     */
    public function dispatch(RequestInterface $request): ResolvedRoute
    {
        $dispatcher = new GroupCountBased($this->routeCollector->getData());
        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());

        switch ($routeInfo[0]) {
            case Dispatcher::METHOD_NOT_ALLOWED:
            case Dispatcher::NOT_FOUND:
                throw new Router\Exception\RouteNotFound();
            case Dispatcher::FOUND:
                return new ResolvedRoute($routeInfo[1], $routeInfo[2]);
        }
    }

    /**
     * @inheritDoc
     */
    public function get(string $route, $handler): void
    {
        $this->add('GET', $route, $handler);
    }

    /**
     * @inheritDoc
     */
    public function add(string $method, string $route, $handler): void
    {
        $this->routeCollector->addRoute($method, $route, $handler);
    }

    /**
     * @inheritDoc
     */
    public function post(string $route, $handler): void
    {
        $this->add('POST', $route, $handler);
    }

    /**
     * @inheritDoc
     */
    public function delete(string $route, $handler): void
    {
        $this->add('DELETE', $route, $handler);
    }

    /**
     * @inheritDoc
     */
    public function put(string $route, $handler): void
    {
        $this->add('PUT', $route, $handler);
    }
    private RouteCollector $routeCollector;
}