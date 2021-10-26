<?php
declare(strict_types=1);

namespace App\Application\UseCases\Box\Delete;

use App\Application\Commands\Command as CommandInterface;

class Command implements CommandInterface
{
    public function __construct(string $identifier)
    {
        $this->identifier = $identifier;
    }

    public function identifier(): string
    {
        return $this->identifier;
    }
    private string $identifier;
}