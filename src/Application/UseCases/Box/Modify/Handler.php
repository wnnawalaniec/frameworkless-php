<?php
declare(strict_types=1);

namespace App\Application\UseCases\Box\Modify;

use App\Application\Commands\Command as commandInterface;
use App\Application\Commands\Handler\BaseHandler;
use App\Application\Commands\Result;
use App\Application\UseCases\Box\Add\Command;
use App\Domain\SharedKernel\Identity\BoxIdentifier;
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
     * @throws \App\Domain\Storage\Box\Exception\BoxNotFound
     * @throws \App\Domain\Storage\Box\Exception\NameIsEmpty
     * @throws \App\Domain\Storage\Box\Exception\NameTooLong
     * @throws \App\Domain\Storage\Box\Exception\NegativeCapacity
     */
    protected function _handle(commandInterface $command): void
    {
        $box = $this->repository->find(new BoxIdentifier($command->identifier()));
        $box->changeName($command->name());
        $box->changeCapacity($command->capacity());
        $this->repository->store($box);
        $command->setResult(Result::create(['box' => $box]));
    }

    private Repository $repository;
}