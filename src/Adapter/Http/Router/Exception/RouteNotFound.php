<?php
declare(strict_types=1);

namespace App\Adapter\Http\Router\Exception;

use App\Adapter\Exception\AdapterException;
use JetBrains\PhpStorm\Pure;

/**
 * Exception for undefined route.
 */
class RouteNotFound extends AdapterException
{
    /**
     * @param string $route
     * @return static
     */
    #[Pure] public static function create(string $route): self
    {
        return new self("Route {$route} not configured.");
    }
}