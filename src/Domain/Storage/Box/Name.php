<?php
declare(strict_types=1);

namespace App\Domain\Storage\Box;

use App\Domain\Storage\Box\Exception\NameIsEmpty;
use App\Domain\Storage\Box\Exception\NameTooLong;
use Stringable;
use function mb_strlen;

class Name implements Stringable
{
    /**
     * @throws NameIsEmpty
     * @throws NameTooLong
     */
    public function __construct(string $value)
    {
        if (trim($value) === '') {
            throw new NameIsEmpty();
        }

        if (mb_strlen($value) > 50) {
            throw new NameTooLong();
        }

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @var string
     */
    private string $value;
}