<?php

namespace Tymeshift\PhpTest\Services;

use Tymeshift\PhpTest\Domains\Schedule\ScheduleEntity;
use Tymeshift\PhpTest\Domains\Schedule\ScheduleRepository;
use Tymeshift\PhpTest\Domains\Task\TaskRepository;

class ScheduleService
{
    /**
     * @var ScheduleRepository
     */
    private ScheduleRepository $scheduleRepository;
    /**
     * @var TaskRepository
     */
    private TaskRepository $taskRepository;

    public function __construct(ScheduleRepository $scheduleRepository, TaskRepository $taskRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->taskRepository = $taskRepository;
    }
    /**
     * @param int $scheduleId
     * @return ScheduleEntity
     */
    public function getScheduleAndRelatedTasks(int $scheduleId): ScheduleEntity
    {
        $schedule = $this->scheduleRepository->getById($scheduleId);
        $tasks = $this->taskRepository->getByScheduleId($scheduleId);
        return $schedule->setItems($tasks->toArray());
    }
}
