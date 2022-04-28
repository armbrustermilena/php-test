<?php
declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Task;

use Tymeshift\PhpTest\Components\HttpClientInterface;

class TaskStorage
{
    private $client;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->client = $httpClient;
    }

    public function getByScheduleId(int $scheduleId): array
    {
        return $this->client->request("GET", "schedules/$scheduleId/tasks");
    }

    public function getById(int $taskId): array
    {
        return $this->client->request("GET", "tasks/$taskId");
    }

    public function getByIds(array $ids): array
    {
        $idsString = implode(",", $ids);
        return $this->client->request("GET", "tasks?id=$idsString");
    }
}
