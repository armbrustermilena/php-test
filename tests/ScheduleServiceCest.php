<?php
declare(strict_types=1);
namespace Tests;

use Codeception\Example;
use Mockery\MockInterface;
use Tymeshift\PhpTest\Domains\Schedule\ScheduleEntity;
use Tymeshift\PhpTest\Domains\Schedule\ScheduleRepository;
use Tymeshift\PhpTest\Domains\Schedule\ScheduleFactory;
use Tymeshift\PhpTest\Domains\Schedule\ScheduleStorage;
use Tymeshift\PhpTest\Domains\Task\TaskFactory;
use Tymeshift\PhpTest\Domains\Task\TaskRepository;
use Tymeshift\PhpTest\Domains\Task\TaskStorage;
use Tymeshift\PhpTest\Exceptions\StorageDataMissingException;
use Tymeshift\PhpTest\Services\ScheduleService;

class ScheduleServiceCest
{

    /**
     * @var MockInterface|ScheduleStorage
     */
    private $scheduleStorageMock;

    /**
     * @var ScheduleRepository
     */
    private $scheduleRepository;
    
    public function _before()
    {
        $this->scheduleStorageMock = \Mockery::mock(ScheduleStorage::class);
        $this->scheduleRepository = new ScheduleRepository($this->scheduleStorageMock, new ScheduleFactory());
        $this->taskStorageMock = \Mockery::mock(TaskStorage::class);
        $this->taskRepository = new TaskRepository($this->taskStorageMock, new TaskFactory());
        $this->scheduleService = new ScheduleService($this->scheduleRepository, $this->taskRepository);
    }

    public function _after()
    {
        $this->scheduleStorageMock = null;
        $this->scheduleRepository = null;
        $this->taskStorageMock = null;
        $this->taskRepository = null;
        $this->scheduleService = null;
        \Mockery::close();
    }

    /**
     * @dataProvider scheduleProvider
     */
    public function testGetScheduleAndRelatedTasksSuccess(Example $example, \UnitTester $tester)
    {
        ['id' => $id, 'start_time' => $startTime, 'end_time' => $endTime, 'name' => $name, 'array' => $array] = $example;

        $this->scheduleStorageMock
            ->shouldReceive('getById')
            ->with($id)
            ->andReturn(['id' => $id, 'start_time' => $startTime, 'end_time' => $endTime, 'name' => $name, 'items' => $array]);

        $this->taskStorageMock
            ->shouldReceive('getByScheduleId')
            ->with($id)
            ->andReturn($array);

        $entity = $this->scheduleService->getScheduleAndRelatedTasks($id);
        $tester->assertInstanceOf(ScheduleEntity::class, $entity);
        $tester->assertObjectHasAttribute('items', $entity);
        $items = $entity->getItems();
        $tester->assertCount(3, $items);
    }

    public function testGetScheduleAndRelatedTasksFail(\UnitTester $tester)
    {
        $this->scheduleStorageMock
            ->shouldReceive('getById')
            ->with(4)
            ->andReturn([]);

        $tester->expectThrowable(StorageDataMissingException::class, function () {
            $this->scheduleService->getScheduleAndRelatedTasks(4);
        });
    }

    /**
     * @return array[]
     */
    public function scheduleProvider()
    {
        return [
            [
                'id' => 1,
                'start_time' => 1631232000,
                'end_time' => 1631232000 + 86400,
                'name' => 'Test',
                'array' => [
                    ["id" => 123, "schedule_id" => 1, "start_time" => 0, "duration" => 3600],
                    ["id" => 431, "schedule_id" => 1, "start_time" => 3600, "duration" => 650],
                    ["id" => 332, "schedule_id" => 1, "start_time" => 5600, "duration" => 3600]
                ]
            ]
        ];
    }
}
