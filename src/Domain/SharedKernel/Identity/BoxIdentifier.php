<?php
declare(strict_types=1);

namespace App\Domain\SharedKernel\Identity;

class BoxIdentifier
{
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
    private string $value;
}