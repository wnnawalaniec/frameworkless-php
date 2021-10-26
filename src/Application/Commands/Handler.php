<?php
declare(strict_types=1);

namespace App\Application\Commands;

use App\Application\Exception\RunTime\InvalidHandlerUsedForHandlingCommand;

/**
 * Interface for command handlers.
 */
interface Handler
{
    /**
     * @param Command $command
     * @return void
     * @throws InvalidHandlerUsedForHandlingCommand
     */
    public function handle(Command $command): void;
}