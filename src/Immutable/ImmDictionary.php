<?php

namespace Collections\Immutable;

use Collections\ConstMapInterface;
use Collections\Iterator\MapIterator;
use Collections\Traits\ImmMapLikeTrait;

class ImmDictionary implements ConstMapInterface
{
    use ImmMapLikeTrait;

    public function __construct($array = null)
    {
        $this->init($array);
    }

    /**
     * Gets the collection's iterator
     * @return MapIterator
     */
    public function getIterator()
    {
        return new MapIterator($this->container);
    }
}
