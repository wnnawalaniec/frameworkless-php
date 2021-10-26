<?php
declare(strict_types=1);

namespace App\Adapter\Http\Router;

/**
 * Object representing matched route. When router has registered path and request uri
 * matches it, this is returned. It contains Handler object registered to handle requests and all parameters from
 * that route.
 */
class ResolvedRoute
{
    public function __construct(Handler $handler, array $variables)
    {
        $this->handler = $handler;
        $this->variables = $variables;
    }

    /**
     * @return array<string, mixed> list of parameters names and it's corresponding value
     */
    public function parameters(): array
    {
        return $this->variables;
    }

    public function handler(): Handler
    {
        return $this->handler;
    }
    private Handler $handler;
    /**
     * @var array<string, mixed>
     */
    private array $variables;
}