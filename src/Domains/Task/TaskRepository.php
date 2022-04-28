<?php
declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Task;

use Tymeshift\PhpTest\Exceptions\StorageDataMissingException;
use Tymeshift\PhpTest\Interfaces\EntityInterface;
use Tymeshift\PhpTest\Interfaces\RepositoryInterface;

class TaskRepository implements RepositoryInterface
{
    /**
     * @var TaskFactory
     */
    private $factory;

    /**
     * @var TaskStorage
     */
    private $storage;

    public function __construct(TaskStorage $storage, TaskFactory $factory)
    {
        $this->factory = $factory;
        $this->storage = $storage;
    }

    public function getById(int $id): EntityInterface
    {
        $data = $this->storage->getById($id);
    
        if (!empty($data)) {
            return $this->factory->createEntity($data);
        }
        
        throw new StorageDataMissingException("No task found", 404);
    }

    /**
     * @throws StorageDataMissingException
     */
    public function getByScheduleId(int $scheduleId):TaskCollection
    {
        $data = $this->storage->getByScheduleId($scheduleId);

        if (!empty($data)) {
            return $this->factory->createCollection($data);
        }

        throw new StorageDataMissingException("No tasks for schedule found", 404);
    }

    public function getByIds(array $ids): TaskCollection
    {
        $data = $this->storage->getByIds($ids);

        if (!empty($data)) {
            return $this->factory->createCollection($data);
        }

        throw new StorageDataMissingException("No tasks for given ids found", 404);
    }
}
