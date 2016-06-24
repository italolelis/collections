<?php

namespace Collections\Immutable;

use Collections\ConstSetInterface;
use Collections\Iterator\SetIterator;
use Collections\Traits\ImmSetLikeTrait;

class ImmSet implements ConstSetInterface
{
    use ImmSetLikeTrait;

    public function __construct($array = null)
    {
        $this->init($array);
    }

    /**
     * Gets the collection's iterator
     * @return SetIterator
     */
    public function getIterator()
    {
        return new SetIterator($this->container);
    }
}
