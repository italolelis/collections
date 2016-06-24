<?php

namespace Collections\Immutable;

use Collections\ConstVectorInterface;
use Collections\Iterator\VectorIterator;
use Collections\Traits\ImmVectorLikeTrait;

class ImmArrayList implements ConstVectorInterface, \ArrayAccess
{
    use ImmVectorLikeTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct($array = null)
    {
        $this->init($array);
    }

    /**
     * Gets the collection's iterator
     * @return VectorIterator
     */
    public function getIterator()
    {
        return new VectorIterator($this->container);
    }
}
