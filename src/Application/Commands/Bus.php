<?php
declare(strict_types=1);

namespace App\Application\Commands;

/**
 * Interface for command bus dispatching commands to proper handlers.
 */
interface Bus
{
    public function dispatch(Command $command): mixed;
}