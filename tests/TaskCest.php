<?php
declare(strict_types=1);

namespace Tests;

use Codeception\Example;
use Mockery\MockInterface;
use Tymeshift\PhpTest\Components\HttpClientInterface;
use Tymeshift\PhpTest\Domains\Task\TaskCollection;
use Tymeshift\PhpTest\Domains\Task\TaskEntity;
use Tymeshift\PhpTest\Domains\Task\TaskFactory;
use Tymeshift\PhpTest\Domains\Task\TaskRepository;
use Tymeshift\PhpTest\Domains\Task\TaskStorage;
use Tymeshift\PhpTest\Exceptions\StorageDataMissingException;

class TaskCest
{
    /**
     * @var TaskRepository
     */
    private $taskRepository;
    /**
     * @var MockInterface|TaskStorage
     */
    private $taskStorageMock;

    public function _before()
    {
        $httpClientMock = \Mockery::mock(HttpClientInterface::class);
        $this->taskStorageMock = \Mockery::mock(new TaskStorage($httpClientMock));
        $this->taskRepository = new TaskRepository($this->taskStorageMock, new TaskFactory());
    }

    public function _after()
    {
        $this->taskRepository = null;
        $this->taskStorageMock = null;
        \Mockery::close();
    }

    /**
     * @dataProvider tasksDataProvider
     */
    public function testGetTasksByScheduleId(Example $example, \UnitTester $tester)
    {
        ['id' => $id, 'array' => $array] = $example;

        $this->taskStorageMock
            ->shouldReceive('getByScheduleId')
            ->with($id)
            ->andReturn($array);

        $tasks = $this->taskRepository->getByScheduleId($id);
        $tester->assertInstanceOf(TaskCollection::class, $tasks);
        $tester->assertCount(3, $tasks);
    }
    
    public function testGetTasksByScheduleIdFailed(\UnitTester $tester)
    {
        $this->taskStorageMock
            ->shouldReceive('getByScheduleId')
            ->with(4)
            ->andReturn([]);
    
        $tester->expectThrowable(new StorageDataMissingException("No tasks for schedule found", 404), function () {
            $this->taskRepository->getByScheduleId(4);
        });
    }

    /**
    * @dataProvider tasksDataProvider
    */
    public function testGetTasksByIdsSuccess(Example $example, \UnitTester $tester)
    {
        ['array' => $array] = $example;
        $ids = [123, 431, 332];

        $this->taskStorageMock
            ->shouldReceive('getByIds')
            ->with($ids)
            ->andReturn($array);

        $tasks = $this->taskRepository->getByIds($ids);
        $tester->assertInstanceOf(TaskCollection::class, $tasks);
        $tester->assertCount(3, $tasks);
    }

    public function testGetTasksByIdsFail(\UnitTester $tester)
    {
        $ids = [1, 2, 3];

        $this->taskStorageMock
            ->shouldReceive('getByIds')
            ->with($ids)
            ->andReturn([]);

        $tester->expectThrowable(new StorageDataMissingException("No tasks for given ids found", 404), function () use ($ids) {
            $this->taskRepository->getByIds($ids);
        });
    }

    /**
    * @dataProvider tasksDataProvider
    */
    public function testGetTasksByIdSuccess(Example $example, \UnitTester $tester)
    {
        ['array' => $array] = $example;
        $data = $array[0];

        $this->taskStorageMock
            ->shouldReceive('getById')
            ->with($data['id'])
            ->andReturn($data);

        $task = $this->taskRepository->getById($data['id']);
        $tester->assertInstanceOf(TaskEntity::class, $task);
        $tester->assertEquals($data['id'], $task->getId());
        $tester->assertEquals($task->getType(), 'Tymeshift\PhpTest\Domains\Task\TaskEntity');
        $tester->assertEquals($task->getEndTime()->getTimestamp(), $data['start_time'] + $data['duration']);
    }


    public function testGetTasksByIdFail(\UnitTester $tester)
    {
        $this->taskStorageMock
            ->shouldReceive('getById')
            ->with(1)
            ->andReturn([]);

        $tester->expectThrowable(new StorageDataMissingException("No task found", 404), function () {
            $this->taskRepository->getById(1);
        });
    }

    public function tasksDataProvider()
    {
        return [
            [
                'id' => 1,
                'array' => [
                    ["id" => 123, "schedule_id" => 1, "start_time" => 0, "duration" => 3600],
                    ["id" => 431, "schedule_id" => 1, "start_time" => 3600, "duration" => 650],
                    ["id" => 332, "schedule_id" => 1, "start_time" => 5600, "duration" => 3600]
                ]
            ]
        ];
    }
}
