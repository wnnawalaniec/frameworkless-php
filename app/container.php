<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$container = new \Pimple\Container();

/*
 * HTTP Adapters
 */

$container[\App\Adapter\Http\Controller\BoxController::class] = function ($c) {
    return new \App\Adapter\Http\Controller\BoxController(
        $c[\App\Application\Controller\BoxController::class]
    );
};

$container[\App\Adapter\Http\Router::class] = function ($c) {
    return new \App\Adapter\Http\Router\Implementation\NikicRouterAdapter(
        new \FastRoute\RouteCollector(new \FastRoute\RouteParser\Std(), new \FastRoute\DataGenerator\MarkBased())
    );
};

$container[\App\Adapter\Http\Emitter::class] = function ($c) {
    return new \App\Adapter\Http\Emitter\Implementation\NarrowsparkHttpEmitterAdapter(
        new \Narrowspark\HttpEmitter\SapiEmitter()
    );
};


/*
 * Command Bus
 */

$container[\App\Application\Commands\Bus::class] = function ($c) {
    $bus = new \App\Infrastructure\Application\Commands\SimpleBus();
    $bus->register(
        \App\Application\UseCases\Box\Add\Command::class,
        $c[\App\Application\UseCases\Box\Add\Handler::class]
    );
    $bus->register(
        \App\Application\UseCases\Box\Delete\Command::class,
        $c[\App\Application\UseCases\Box\Delete\Handler::class]
    );

    $bus->register(
        \App\Application\UseCases\Box\Modify\Command::class,
        $c[\App\Application\UseCases\Box\Modify\Handler::class]
    );
    return $bus;
};

/*
 * Handlers
 */

$container[\App\Application\UseCases\Box\Add\Handler::class] = function ($c) {
    return new \App\Application\UseCases\Box\Add\Handler($c[\App\Domain\Storage\Box\Repository::class]);
};

$container[\App\Application\UseCases\Box\Modify\Handler::class] = function ($c) {
    return new \App\Application\UseCases\Box\Modify\Handler($c[\App\Domain\Storage\Box\Repository::class]);
};

$container[\App\Application\UseCases\Box\Delete\Handler::class] = function ($c) {
    return new \App\Application\UseCases\Box\Delete\Handler($c[\App\Domain\Storage\Box\Repository::class]);
};

/*
 * Controllers
 */

$container[\App\Application\Controller\BoxController::class] = function ($c) {
    return new \App\Application\Controller\BoxController(
        $c[\App\Domain\Storage\Box\Repository::class],
        $c[\App\Application\Commands\Bus::class]
    );
};

/*
 * Repositories
 */

$container[\App\Domain\Storage\Box\Repository::class] = function ($c) {
    return new \App\Infrastructure\Domain\Storage\Box\Repository\FileRepository(
        __DIR__ . '/../storage/boxes'
    );
};

$container = new \Pimple\Psr11\Container($container);