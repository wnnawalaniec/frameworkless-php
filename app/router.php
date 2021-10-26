<?php
declare(strict_types=1);

use App\Adapter\Http\Router\Handler\ContainerAwareCallingHandler as Handler;

global $container;

$handler = fn ($class, $method) => Handler::create($container, $class, $method);

$container->get(\App\Adapter\Http\Router::class)->get(
    "/api/box",
    $handler(\App\Adapter\Http\Controller\BoxController::class, 'all')
);

$container->get(\App\Adapter\Http\Router::class)->get(
    "/api/box/{identifier}",
    $handler(\App\Adapter\Http\Controller\BoxController::class, 'one')
);

$container->get(\App\Adapter\Http\Router::class)->post(
    "/api/box",
    $handler(\App\Adapter\Http\Controller\BoxController::class, 'add')
);

$container->get(\App\Adapter\Http\Router::class)->delete(
    "/api/box",
    $handler(\App\Adapter\Http\Controller\BoxController::class, 'delete')
);

$container->get(\App\Adapter\Http\Router::class)->put(
    "/api/box/{identifier}",
    $handler(\App\Adapter\Http\Controller\BoxController::class, 'modify')
);