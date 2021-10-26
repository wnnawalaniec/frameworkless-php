<?php
declare(strict_types=1);

namespace App\Application\Commands;

use JetBrains\PhpStorm\Pure;

/**
 * Result of handling command carrying some data.
 */
class Result
{
    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param array $resultData
     * @return static
     */
    #[Pure] public static function create(array $resultData): self
    {
        return new self($resultData);
    }

    /**
     * @return bool
     */
    public function hasData(): bool
    {
        return !empty($this->data);
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return $this->data;
    }

    /**
     * @var array
     */
    private array $data;
}