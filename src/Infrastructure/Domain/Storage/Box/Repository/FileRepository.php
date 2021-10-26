<?php
declare(strict_types=1);

namespace App\Infrastructure\Domain\Storage\Box\Repository;

use App\Domain\SharedKernel\Identity\BoxIdentifier;
use App\Domain\Storage\Box;
use Ramsey\Uuid\Uuid;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use function file_get_contents;
use function json_decode;

class FileRepository implements Box\Repository
{
    /**
     * FileRepository constructor.
     * @param $dir
     */
    public function __construct(string $dir)
    {
        $this->dir = $dir;

        if (!file_exists($dir)) {
            mkdir($dir);
        }
    }

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        $iterator = new RecursiveDirectoryIterator($this->dir);
        $iterator->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($iterator);

        $boxes = [];
        foreach ($files as $file) {
            $boxes[] = $this->deserialize($file->getPathname());
        }

        return $boxes;
    }

    /**
     * @param string $file
     * @return Box
     * @throws Box\Exception\NameIsEmpty
     * @throws Box\Exception\NameTooLong
     * @throws Box\Exception\NegativeCapacity
     */
    private function deserialize(string $file): Box
    {
        $box = json_decode(file_get_contents($file), true);
        return new Box(new BoxIdentifier($box['identifier']), $box['name'], $box['capacity']);
    }

    /**
     * @inheritDoc
     */
    public function store(Box $box): void
    {
        file_put_contents($this->path($box->identifier()), json_encode($box));
    }

    /**
     * @param BoxIdentifier $identifier
     * @return string
     */
    private function path(BoxIdentifier $identifier): string
    {
        return $this->dir . '/' . $identifier . '.box';
    }

    /**
     * @inheritDoc
     */
    public function remove(Box $box): void
    {
        unlink($this->path($box->identifier()));
    }

    /**
     * @inheritDoc
     */
    public function nextIdentifier(): BoxIdentifier
    {
        $identifier = new BoxIdentifier(Uuid::uuid4()->toString());

        try {
            $this->find($identifier);
        } catch (Box\Exception\BoxNotFound $e) {
            return $identifier;
        }

        return $this->nextIdentifier();
    }

    /**
     * @inheritDoc
     */
    public function find(BoxIdentifier $id): Box
    {
        $filename = $this->path($id);
        if (!file_exists($filename)) {
            throw new Box\Exception\BoxNotFound();
        }

        return $this->deserialize($filename);
    }
    /**
     * @var string
     */
    private string $dir;
}