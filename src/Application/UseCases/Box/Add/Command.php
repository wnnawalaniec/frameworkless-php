<?php
declare(strict_types=1);

namespace App\Application\UseCases\Box\Add;

use App\Application\Commands\Command as CommandInterface;

/**
 * Command representing intention of adding new box.
 */
class Command extends CommandInterface\BaseCommandWithResult
{
    /**
     * @param string $name
     * @param int $capacity
     */
    public function __construct(string $name, int $capacity)
    {
        $this->name = $name;
        $this->capacity = $capacity;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function capacity(): int
    {
        return $this->capacity;
    }

    /**
     * @var string
     */
    private string $name;
    /**
     * @var int
     */
    private int $capacity;
}