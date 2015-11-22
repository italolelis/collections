<?php

namespace Collections\Immutable;

use Collections\AbstractConstCollectionArray;
use Collections\ConstVectorInterface;
use Collections\Iterator\VectorIterator;
use Collections\Traits\GuardTrait;
use Collections\Traits\StrictKeyedIterableTrait;
use OutOfBoundsException;

class ImmArrayList extends AbstractConstCollectionArray implements ConstVectorInterface
{
    use StrictKeyedIterableTrait,
        GuardTrait;

    public function at($key)
    {
        $this->validateKeyType($key);
        $this->validateKeyBounds($key);

        return $this->container[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function get($index)
    {
        $this->validateKeyType($index);

        if ($this->containsKey($index) === false) {
            throw new OutOfBoundsException('No element at position ' . $index);
        }

        return $this->container[$index];
    }

    /**
     * {@inheritdoc}
     */
    public function containsKey($key)
    {
        $this->validateKeyType($key);

        return $key >= 0 && $key < $this->count();
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