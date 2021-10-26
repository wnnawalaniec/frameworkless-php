<?php
declare(strict_types=1);

namespace App\Application\Commands\Command;

use App\Application\Commands\Command;
use App\Application\Commands\Result;
use RuntimeException;

/**
 * Base abstraction for all commands with result.
 */
abstract class BaseCommandWithResult implements WithResult, Command
{
    /**
     * @return Result
     */
    public function result(): Result
    {
        if (!isset($this->result)) {
            throw new RuntimeException('Result was not set');
        }

        return $this->result;
    }

    /**
     * @param Result $result
     * @return void
     */
    public function setResult(Result $result): void
    {
        $this->result = $result;
    }

    /**
     * @var Result
     */
    protected Result $result;
}