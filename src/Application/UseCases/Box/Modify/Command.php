<?php
declare(strict_types=1);

namespace App\Application\UseCases\Box\Modify;

use App\Application\Commands\Command as CommandInterface;

class Command extends CommandInterface\BaseCommandWithResult
{
    public function __construct(string $identifier, string $name, int $capacity)
    {
        $this->name = $name;
        $this->capacity = $capacity;
        $this->identifier = $identifier;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function identifier(): string
    {
        return $this->identifier;
    }

    public function capacity(): int
    {
        return $this->capacity;
    }
    private string $identifier;
    private string $name;
    private int $capacity;
}