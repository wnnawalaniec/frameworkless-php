<?php
declare(strict_types=1);

namespace App\Domain\Storage;

use App\Domain\SharedKernel\Identity\BoxIdentifier;
use App\Domain\Storage\Box\Capacity;
use App\Domain\Storage\Box\Exception\NameIsEmpty;
use App\Domain\Storage\Box\Exception\NameTooLong;
use App\Domain\Storage\Box\Exception\NegativeCapacity;
use App\Domain\Storage\Box\Name;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use JsonSerializable;

class Box implements JsonSerializable
{
    /**
     * @throws NameIsEmpty
     * @throws NameTooLong
     * @throws NegativeCapacity
     */
    public function __construct(BoxIdentifier $identifier, string $name, int $capacity)
    {
        $this->identifier = $identifier;
        $this->name = new Name($name);
        $this->capacity = new Capacity($capacity);
    }

    /**
     * @return BoxIdentifier
     */
    public function identifier(): BoxIdentifier
    {
        return $this->identifier;
    }

    /**
     * @return Name
     */
    public function name(): Name
    {
        return $this->name;
    }

    /**
     * @return Capacity
     */
    public function capacity(): Capacity
    {
        return $this->capacity;
    }

    /**
     * @throws NameIsEmpty
     * @throws NameTooLong
     */
    public function changeName(string $name): void
    {
        $this->name = new Name($name);
    }

    /**
     * @throws NegativeCapacity
     */
    public function changeCapacity(int $capacity): void
    {
        $this->capacity = new Capacity($capacity);
    }

    /**
     * @return array
     */
    #[Pure]
    #[ArrayShape(['identifier' => "string", 'name' => "\App\Domain\Box\Name", 'capacity' => "\App\Domain\Box\Capacity"])]
    public function jsonSerialize(): array
    {
        return [
            'identifier' => (string)$this->identifier,
            'name' => $this->name->value(),
            'capacity' => $this->capacity->value()
        ];
    }

    /**
     * @var BoxIdentifier
     */
    private BoxIdentifier $identifier;
    /**
     * @var Name
     */
    private Name $name;
    /**
     * @var Capacity
     */
    private Capacity $capacity;
}