<?php

namespace Tests\Collections;

use Easy\Generics\EquatableInterface;

class EquatableClass implements EquatableInterface
{
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function equals($other)
    {
        return $this->name <=> $other->name;
    }
}
