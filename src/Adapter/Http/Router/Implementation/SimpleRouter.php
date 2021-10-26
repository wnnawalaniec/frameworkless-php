<?php
declare(strict_types=1);

namespace App\Adapter\Http\Router\Implementation;

use App\Adapter\Http\Router;
use App\Adapter\Http\Router\ResolvedRoute;
use App\Adapter\Http\Router\Route;
use Psr\Http\Message\RequestInterface;

/**
 * Example of implementing Router by ourselves.
 */
class SimpleRouter implements Router
{
    /**
     * @inheritDoc
     */
    public function dispatch(RequestInterface $request): ResolvedRoute
    {
        $routes = $this->routes[$request->getMethod()];

        if (count($routes) === 0) {
            throw new Router\Exception\RouteNotFound();
        }

        foreach ($routes as $routeInfo) {
            if ($routeInfo['route']->match($request->getUri()->getPath())) {
                return new ResolvedRoute(
                    $routeInfo['handler'],
                    $this->routeParams($request, $routeInfo['route'])
                );
            }
        }

        throw new Router\Exception\RouteNotFound();
    }

    /**
     * @param RequestInterface $request
     * @param Route $route
     * @return array<string, mixed>
     */
    private function routeParams(RequestInterface $request, Route $route): array
    {
        return $route->params($request->getUri()->getPath());
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
        $this->routes[$method][] = [
            'route' => Route::create($route),
            'handler' => $handler
        ];
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

    /**
     * @var array<string, array{"route": Route, "handler": string|callable}>
     */
    private array $routes = [];
}