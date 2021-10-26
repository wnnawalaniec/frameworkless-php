<?php
declare(strict_types=1);

namespace App\Application\Commands\Handler;

use App\Application\Commands\Command;
use App\Application\Commands\Handler;
use App\Application\Exception\RunTime\InvalidHandlerUsedForHandlingCommand;

/**
 * Base handler class doing checking for type of command received in handle method
 * which should be done in every handler.
 */
abstract class BaseHandler implements Handler
{
    /**
     * @inheritdoc
     */
    public function handle(Command $command): void
    {
        $this->throwExceptionIfCannotHandle($command);
        $this->_handle($command);
    }

    /**
     * @throws InvalidHandlerUsedForHandlingCommand
     */
    protected function throwExceptionIfCannotHandle(Command $command): void
    {
        if (\get_class($command) !== $this->handlingCommand()) {
            throw InvalidHandlerUsedForHandlingCommand::create(
                $this,
                $command,
                Command::class
            );
        }
    }

    /**
     * @return string full name of command class
     */
    protected abstract function handlingCommand(): string;

    /**
     * Actual command handling.
     * @param Command $command
     * @return void
     */
    protected abstract function _handle(Command $command): void;
}