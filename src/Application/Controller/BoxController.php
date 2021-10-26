<?php
declare(strict_types=1);

namespace App\Application\Controller;

use App\Application\Commands\Bus;
use App\Application\Commands\Command\WithResult;
use App\Application\Exception\RunTime\CommandWithoutResultData;
use App\Application\UseCases\Box\Add\Command as AddCommand;
use App\Application\UseCases\Box\Delete\Command as DeleteCommand;
use App\Application\UseCases\Box\Modify\Command as ModifyCommand;
use App\Domain\SharedKernel\Identity\BoxIdentifier;
use App\Domain\Storage\Box;
use App\Domain\Storage\Box\Repository;

/**
 * Application controller for controlling boxes business logic execution.
 */
class BoxController
{
    /**
     * @param Repository $repository
     * @param Bus $commandBus
     */
    public function __construct(Repository $repository, Bus $commandBus)
    {
        $this->repository = $repository;
        $this->commandBus = $commandBus;
    }

    /**
     * @throws Box\Exception\BoxNotFound
     */
    public function one(string $identifier): Box
    {
        return $this->repository->find(new BoxIdentifier($identifier));
    }

    /**
     * @return Box[]
     */
    public function all(): array
    {
        return $this->repository->all();
    }

    /**
     * @param array{"name": string, "capacity": int} $box
     * @return Box
     * @throws Box\Exception\NameIsEmpty
     * @throws Box\Exception\NameTooLong
     * @throws Box\Exception\NegativeCapacity
     * @throws CommandWithoutResultData
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function add(array $box): Box
    {
        $command = new AddCommand($box['name'], (int)$box['capacity']);
        $this->commandBus->dispatch($command);
        $this->throwExceptionIfCommandWithEmptyResult($command);

        /*
         * It's not fancy, but we know that every command has exactly one handler, and we know it.
         * So in my opinion is safe to use keys like 'box' here.
         */
        return $command->result()->data()['box'];
    }

    /**
     * @param string $identifier
     * @param array{"name": string, "capacity": int} $box
     * @return Box
     * @throws Box\Exception\BoxNotFound
     * @throws Box\Exception\NameIsEmpty
     * @throws Box\Exception\NameTooLong
     * @throws Box\Exception\NegativeCapacity
     * @throws CommandWithoutResultData
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function modify(string $identifier, array $box): Box
    {
        $command = new ModifyCommand($identifier, $box['name'], (int)$box['capacity']);
        $this->commandBus->dispatch($command);
        $this->throwExceptionIfCommandWithEmptyResult($command);

        return $command->result()->data()['box'];
    }

    /**
     * @param ModifyCommand $command
     * @return void
     * @throws CommandWithoutResultData
     */
    protected function throwExceptionIfCommandWithEmptyResult(WithResult $command): void
    {
        if (!$command->result()->hasData()) {
            throw CommandWithoutResultData::create($command);
        }
    }

    /**
     * @param string $identifier
     * @return void
     */
    public function delete(string $identifier): void
    {
        $command = new DeleteCommand($identifier);
        $this->commandBus->dispatch($command);
    }

    /**
     * @var Repository
     */
    private Repository $repository;
    /**
     * @var Bus
     */
    private Bus $commandBus;
}