<?php
declare(strict_types=1);

namespace App\Application\UseCases\Box\Delete;

use App\Application\Commands\Command as commandInterface;
use App\Application\Commands\Handler\BaseHandler;
use App\Application\UseCases\Box\Add\Command;
use App\Domain\SharedKernel\Identity\BoxIdentifier;
use App\Domain\Storage\Box;
use App\Domain\Storage\Box\Repository;

class Handler extends BaseHandler
{
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritdoc
     */
    protected function handlingCommand(): string
    {
        return Command::class;
    }

    /**
     * @param commandInterface $command
     * @return void
     */
    protected function _handle(commandInterface $command): void
    {
        $identifier = new BoxIdentifier($command->identifier());
        try {
            $box = $this->repository->find($identifier);
        } catch (Box\Exception\BoxNotFound $e) {
            return;
        }
        $this->repository->remove($box);
    }

    private Repository $repository;
}