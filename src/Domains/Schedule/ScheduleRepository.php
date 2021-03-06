<?php

namespace Tymeshift\PhpTest\Domains\Schedule;

use Tymeshift\PhpTest\Domains\Schedule\ScheduleStorage;
use Tymeshift\PhpTest\Exceptions\StorageDataMissingException;
use Tymeshift\PhpTest\Interfaces\EntityInterface;
use Tymeshift\PhpTest\Interfaces\FactoryInterface;

class ScheduleRepository
{
    private $storage;

    private $factory;

    public function __construct(ScheduleStorage $storage, FactoryInterface $factory)
    {
        $this->storage = $storage;
        $this->factory = $factory;
    }
    /**
     * @param int $id
     * @return EntityInterface
     * @throws StorageDataMissingException
     */
    public function getById(int $id): EntityInterface
    {
        if (!empty($data = $this->storage->getById($id))) {
            return $this->factory->createEntity($data);
        }
        
        throw new StorageDataMissingException("Schedule not found.", 404);
    }
}
