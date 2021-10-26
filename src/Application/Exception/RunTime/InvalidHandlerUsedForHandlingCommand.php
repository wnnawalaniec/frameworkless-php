<?php
declare(strict_types=1);

namespace App\Application\Exception\RunTime;

use App\Application\Commands\Command;
use App\Application\Commands\Handler;
use App\Application\Exception\RunTimeException;
use JetBrains\PhpStorm\Pure;

/**
 * Runtime exception thrown when handler wasn't designed to handle some command.
 * This probably indicates error in Bus configuration.
 */
class InvalidHandlerUsedForHandlingCommand extends RunTimeException
{
    /**
     * @param Handler $usedHandler
     * @param Command $unsupportedCommand
     * @param string $supportedCommandClass
     * @return static
     */
    #[Pure] public static function create(
        Handler $usedHandler,
        Command $unsupportedCommand,
        string $supportedCommandClass
    ): self
    {
        return new self(sprintf(
            'This handler: %s was tried to be used with command %s but it only can be used with %s',
            \get_class($usedHandler),
            \get_class($unsupportedCommand),
            $supportedCommandClass
        ));
    }
}