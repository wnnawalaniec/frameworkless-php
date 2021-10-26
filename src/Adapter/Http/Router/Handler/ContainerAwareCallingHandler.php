<?php
declare(strict_types=1);

namespace App\Adapter\Http\Router\Handler;

use App\Adapter\Http\Router\Handler;
use JetBrains\PhpStorm\Pure;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * This handler uses PSR container to obtain given container and executes method passed in constructor.
 * There is no checking if controller exists in the container nor that method with same signature
 * as "call" method exists within controller. This lack of validation is due to performance issues as checking makes
 * only sense in the constructor.
 */
class ContainerAwareCallingHandler implements Handler
{
    /**
     * @param ContainerInterface $container
     * @param string $containerKey
     * @param string $method
     */
    private function __construct(ContainerInterface $container, string $containerKey, string $method)
    {
        $this->container = $container;
        $this->containerKey = $containerKey;
        $this->method = $method;
    }

    /**
     * @param ContainerInterface $container
     * @param string $containerKey
     * @param string $method
     * @return static
     */
    #[Pure] public static function create(ContainerInterface $container, string $containerKey, string $method): self
    {
        return new self($container, $containerKey, $method);
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param array $params
     * @return ResponseInterface
     */
    public function call(
        RequestInterface $request,
        ResponseInterface $response,
        array $params = []
    ): ResponseInterface
    {
        $object = $this->container->get($this->containerKey);
        return $object->{$this->method}($request, $response, $params);
    }
    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;
    /**
     * @var string
     */
    private string $containerKey;
    /**
     * @var string
     */
    private string $method;
}