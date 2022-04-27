<?php
declare(strict_types=1);

namespace Tymeshift\PhpTest\Exceptions;

class InvalidCollectionDataProvidedException extends \Exception
{
    const MESSAGE = 'Invalid data provided for building collection';

    public function __construct()
    {
        parent::__construct(self::MESSAGE, 500);
    }
}