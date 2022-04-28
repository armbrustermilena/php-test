<?php
namespace Tymeshift\PhpTest\Components;

use Tymeshift\PhpTest\Interfaces\EntityInterface;

class Entity implements EntityInterface
{
    /**
     * Converts object of class Entity to the associative array
     * Should be improved by custom implementation - going trough all the object's
     * attributes and converting them appropriately by taking into the consideration data type
     * @return array
     */
    public function toArray(): array
    {
        return json_decode(json_encode($this), true);
    }
}
