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

    public function getByScheduleId(int $id): array
    {

    }

    public function getByIds(array $ids): array
    {
        // TODO: Implement getByIds() method.
    }
}