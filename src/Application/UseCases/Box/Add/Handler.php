<?php
declare(strict_types=1);

namespace App\Application\UseCases\Box\Add;

use App\Application\Commands\Command as commandInterface;
use App\Application\Commands\Handler\BaseHandler;
use App\Application\Commands\Result;
use App\Domain\Storage\Box;
use App\Domain\Storage\Box\Repository;

/**
 * Handler for command of adding new box.
 */
class Handler extends BaseHandler
{
    /**
     * @param Repository $repository
     */
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
     * @throws Box\Exception\NameIsEmpty
     * @throws Box\Exception\NameTooLong
     * @throws Box\Exception\NegativeCapacity
     */
    protected function _handle(commandInterface $command): void
    {
        $identifier = $this->repository->nextIdentifier();
        $box = new Box(
            $identifier,
            $command->name(),
            $command->capacity()
        );

        $this->repository->store($box);
        $command->setResult(Result::create(['box' => $box]));
    }

    /**
     * @var Repository
     */
    private Repository $repository;
}