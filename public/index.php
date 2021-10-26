<?php
declare(strict_types=1);

use App\Adapter\Http\Router;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;

require_once __DIR__ . '/../app/container.php';
require_once __DIR__ . '/../app/router.php';

global $container;

$request = ServerRequest::fromGlobals();
$response = new Response();

/** @var Router $router */
$router = $container->get(Router::class);
try {
    $routeInfo = $router->dispatch($request);
} catch (Router\Exception\RouteNotFound $e) {
    $response = \App\Adapter\Http\Controller\BaseController::return404($response);
    $container->get(\App\Adapter\Http\Emitter::class)->emit($response);
    die();
}

try {
    $response = $routeInfo->handler()->call($request, $response, $routeInfo->parameters());
} catch (\App\Infrastructure\Exception\InvalidRequest $exception) {
    $response = \App\Adapter\Http\Controller\BaseController::return400($response, $exception->getMessage());
} catch (\Exception $exception) {
    $response = \App\Adapter\Http\Controller\BaseController::return400($response, "UNEXPECTED_EXCEPTION");
}
$container->get(\App\Adapter\Http\Emitter::class)->emit($response);
