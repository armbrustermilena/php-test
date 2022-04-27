<?php
declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Task;

use Tymeshift\PhpTest\Exceptions\InvalidCollectionDataProvidedException;
use Tymeshift\PhpTest\Interfaces\CollectionInterface;
use Tymeshift\PhpTest\Interfaces\EntityInterface;
use Tymeshift\PhpTest\Interfaces\FactoryInterface;

class TaskFactory implements FactoryInterface
{

    public function createEntity(array $data): EntityInterface
    {
        // TODO: Implement createEntity() method.
    }

    /**
     * @throws InvalidCollectionDataProvidedException
     */
    public function createCollection(array $data):CollectionInterface
    {
        return (new TaskCollection())->createFromArray($data, $this);
    }
}