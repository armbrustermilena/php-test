<?php
declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Schedule;

use DateTime;

interface ScheduleItemInterface
{
    /**
     * @return int
     */
    public function getScheduleId():int;

    /**
     * @return DateTime
     */
    public function getStartTime():DateTime;

    /**
     * @return DateTime
     */
    public function getEndTime():DateTime;

    /**
     * @return string
     */
    public function getType():string;
}
