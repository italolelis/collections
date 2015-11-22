<?php

namespace Collections\Immutable;

use Collections\AbstractConstCollectionArray;
use Collections\ConstMapInterface;
use Collections\Iterator\MapIterator;
use Collections\Traits\StrictKeyedIterableTrait;
use Symfony\Component\PropertyAccess\Exception\OutOfBoundsException;

class ImmDictionary extends AbstractConstCollectionArray implements ConstMapInterface
{
    use StrictKeyedIterableTrait;

    public function at($k)
    {
        return $this[$k];
    }

    /**
     * {@inheritdoc}
     */
    public function get($index)
    {
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
        return array_key_exists($key, $this->container);
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
     * @return MapIterator
     */
    public function getIterator()
    {
        return new MapIterator($this->container);
    }

}
