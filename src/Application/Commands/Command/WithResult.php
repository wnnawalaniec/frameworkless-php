<?php
declare(strict_types=1);

namespace App\Application\Commands\Command;

use App\Application\Commands\Result;

/**
 * Interface for commands which handling creates some data to return.
 */
interface WithResult
{
    /**
     * @return Result
     */
    public function result(): Result;

    /**
     * @param Result $result
     * @return void
     */
    public function setResult(Result $result): void;
}