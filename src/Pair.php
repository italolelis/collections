<?php

namespace Collections;

class Pair
{
    public $first;

    public $second;

    public function __construct($first, $second)
    {
        $this->first = $first;
        $this->second = $second;
    }
}
