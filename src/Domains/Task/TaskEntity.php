<?php
declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Task;

use DateTime;
use Tymeshift\PhpTest\Components\Entity;
use Tymeshift\PhpTest\Domains\Schedule\ScheduleItemInterface;

class TaskEntity extends Entity implements ScheduleItemInterface
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var int
     */
    private int $scheduleId;

    /**
     * @var DateTime
     */
    private DateTime $startTime;


    /**
     * @var int
     */
    private int $duration;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return TaskEntity
     */
    public function setId(int $id): TaskEntity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getScheduleId(): int
    {
        return $this->scheduleId;
    }

    /**
     * @param int $id
     * @return TaskEntity
     */
    public function setScheduleId(int $scheduleId): TaskEntity
    {
        $this->scheduleId = $scheduleId;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getStartTime(): DateTime
    {
        return $this->startTime;
    }

    /**
     * @param DateTime $startTime
     * @return TaskEntity
     */
    public function setStartTime(DateTime $startTime): TaskEntity
    {
        $this->startTime = $startTime;
        return $this;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int $endTime
     * @return TaskEntity
     */
    public function setDuration(int $duration): TaskEntity
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getEndTime(): DateTime
    {
        $endTime = $this->startTime->getTimestamp() + $this->duration;
        return (new \DateTime())->setTimestamp($endTime);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return get_class();
    }
}
