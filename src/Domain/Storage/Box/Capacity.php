<?php
declare(strict_types=1);

namespace App\Domain\Storage\Box;

use App\Domain\Storage\Box\Exception\NegativeCapacity;

class Capacity
{
    /**
     * @throws NegativeCapacity
     */
    public function __construct(int $value)
    {
        if ($value < 0) {
            throw new NegativeCapacity();
        }

        $this->value = $value;
    }

    /**
     * @return int
     */
    public function value(): int
    {
        return $this->value;
    }

    /**
     * @var int
     */
    private int $value;
}