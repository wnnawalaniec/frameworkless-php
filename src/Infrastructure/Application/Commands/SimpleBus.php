<?php
declare(strict_types=1);

namespace App\Infrastructure\Application\Commands;

use App\Application\Commands\Bus;
use App\Application\Commands\Command;
use App\Application\Commands\Handler;
use RuntimeException;

class SimpleBus implements Bus
{
    /**
     * @param string $command
     * @param Handler $handler
     * @return void
     */
    public function register(string $command, Handler $handler): void
    {
        $this->map[$command] = $handler;
    }

    /**
     * @param Command $command
     * @return mixed
     * @throws \App\Application\Exception\RunTime\InvalidHandlerUsedForHandlingCommand
     */
    public function dispatch(Command $command): mixed
    {
        $commandType = get_class($command);
        if (!array_key_exists($commandType, $this->map)) {
            throw new RuntimeException("Command {$commandType} not registered with any handler");
        }

        return $this->map[$commandType]->handle($command);
    }

    /** @var array<string, Handler> */
    private array $map = [];
}