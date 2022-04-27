<?php
declare(strict_types=1);

namespace Tymeshift\PhpTest\Components;

interface DatabaseInterface
{
    /**
     * @param string $query
     * @param array $params
     * @return array
     */
    public function query(string $query, array $params):array;
}