<?php
declare(strict_types=1);

namespace App\Domain\Storage\Box;

use App\Domain\SharedKernel\Identity\BoxIdentifier;
use App\Domain\Storage\Box;
use App\Domain\Storage\Box\Exception\BoxNotFound;

interface Repository
{
    /**
     * @throws BoxNotFound
     */
    public function find(BoxIdentifier $id): Box;

    /**
     * @return Box[]
     */
    public function all(): array;

    /**
     * @param Box $box
     * @return void
     */
    public function store(Box $box): void;

    /**
     * @param Box $box
     * @return void
     */
    public function remove(Box $box): void;

    /**
     * @return BoxIdentifier
     */
    public function nextIdentifier(): BoxIdentifier;
}