<?php
declare(strict_types=1);

namespace App\Application\Exception\RunTime;

use App\Application\Commands\Command;
use App\Application\Exception\RunTimeException;
use JetBrains\PhpStorm\Pure;

/**
 * Runtime exception for case when some place dispatching command is excepting it to has a data result.
 */
class CommandWithoutResultData extends RunTimeException
{
    /**
     * @param Command $command
     * @return static
     */
    #[Pure] public static function create(Command $command): self
    {
        return new self(
            sprintf('Command %s was expected to have result data, but got one without it', \get_class($command))
        );
    }
}