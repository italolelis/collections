<?php

namespace Collections\Immutable;

use Collections\AbstractConstCollectionArray;
use Collections\ConstSetInterface;
use Collections\Iterator\SetIterator;
use Collections\Traits\GuardTrait;
use Collections\Traits\StrictKeyedIterableTrait;

class ImmSet extends AbstractConstCollectionArray implements ConstSetInterface
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
            throw new \OutOfBoundsException('No element at position ' . $index);
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
     * {@inheritdoc}
     */
    public function contains($element)
    {
        return in_array($element, $this->container, true);
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