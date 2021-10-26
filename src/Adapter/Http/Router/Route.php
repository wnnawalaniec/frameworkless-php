<?php
declare(strict_types=1);

namespace App\Adapter\Http\Router;

use function array_filter;

/**
 * Very simple and naive route object.
 *
 * It takes route pattern like e.g. /api/order/{id} and creates regular expression
 * from it.
 *
 * Then it uses this regexp to validate if path matches route and also can extract
 * parameters from path. E.g. for above route, and path like '/api/order/1'
 * it will return true for match() method and array like:
 * [
 *   'id' => 1
 * ]
 *
 * for params method.
 *
 * It is super simple and doesn't allow for any fancy param regexp. It also doesn't do
 * proper route validation.
 *
 * @package App
 */
class Route
{
    public function __construct(string $route)
    {
        $this->routRegexp = $this->parse($route);
    }

    /**
     * Creates regexp from route.
     *
     * @param string $route
     * @return string
     */
    private function parse(string $route): string
    {
        $regexp = "/^" . str_replace("/", "\/", $route) . "$/";
        $routeParameters = $this->parametersFromRoutePattern($route);
        foreach ($routeParameters as $parameter) {
            $paramName = trim($parameter, "{}");
            $this->parametersNames[] = $paramName;
            $paramRegexp = "(?<{$paramName}>[a-zA-Z0-9-+_]+)";
            $regexp = str_replace($parameter, $paramRegexp, $regexp);
        }

        return $regexp;
    }

    /**
     * @param string $route
     * @return array
     */
    private function parametersFromRoutePattern(string $route): array
    {
        preg_match_all("/\{\w+\}/", $route, $routeParameters);
        return $routeParameters[0];
    }

    /**
     * @param string $route
     * @return static
     */
    public static function create(string $route): self
    {
        return new self($route);
    }

    /**
     * Check if path match route
     *
     * @param string $path
     * @return bool
     */
    public function match(string $path): bool
    {
        return preg_match($this->routRegexp, $path) === 1;
    }

    /**
     * Returns array of parameters and it's value
     *
     * @param string $path
     * @return array<string, mixed>
     */
    public function params(string $path): array
    {
        preg_match($this->routRegexp, $path, $matches);
        return array_filter(
            $matches,
            function ($k) {
                return in_array($k, $this->parametersNames, true);
            },
            ARRAY_FILTER_USE_KEY
        );
    }
    /**
     * Regular expression for matching request path
     *
     * @var string
     */
    private string $routRegexp;
    /**
     * All parameters name from route
     *
     * @var string[]
     */
    private array $parametersNames = [];
}