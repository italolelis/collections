<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

use Collections\Exception\KeyException;
use Collections\Iterator\MapIterator;
use Collections\Traits\GuardTrait;
use Collections\Traits\StrictKeyedIterableTrait;
use InvalidArgumentException;
use Symfony\Component\PropertyAccess\Exception\OutOfBoundsException;
use Traversable;

/**
 * Represents a collection of keys and values.
 */
class Dictionary extends AbstractCollectionArray implements MapInterface, \ArrayAccess
{
    use StrictKeyedIterableTrait,
        GuardTrait;

    /**
     * {@inheritdoc}
     */
    public function at($k)
    {
        return $this[$k];
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        $this->container[$key] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function get($index)
    {
        if ($this->containsKey($index) === false) {
            throw new OutOfBoundsException('No element at position '.$index);
        }

        return $this->container[$index];
    }

    /**
     * {@inheritdoc}
     */
    public function add($key, $value)
    {
        if ($this->containsKey($key)) {
            throw new KeyException('The key '.$key.' already exists!');
        }
        $this->set($key, $value);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addAll($items)
    {
        if (!is_array($items) && !$items instanceof Traversable) {
            throw new \InvalidArgumentException('The items must be an array or Traversable');
        }

        foreach ($items as $key => $value) {
            if (is_array($value)) {
                $value = Dictionary::fromArray($value);
            }
            $this->add($key, $value);
        }
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
     * {@inheritdoc}
     */
    public function remove($element)
    {
        $this->validateKeyBounds($element);
        unset($this->container[$element]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeKey($key)
    {
        return $this->remove($key);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]) || array_key_exists($offset, $this->container);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->add($offset, $value);
        } else {
            $this->set($offset, $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        $this->removeKey($offset);
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
