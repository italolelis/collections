<?php

// Copyright (c) italolelis. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

use Collections\Exception\KeyException;
use Collections\Iterator\MapIterator;
use Collections\Traits\GuardTrait;
use Collections\Traits\StrictKeyedIterableTrait;

/**
 * Represents a collection of keys and values.
 */
class Dictionary extends AbstractConstCollectionArray implements MapInterface, \ArrayAccess
{
    use GuardTrait,
        StrictKeyedIterableTrait;

    public function at($k)
    {
        return $this[$k];
    }

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
            throw new \OutOfBoundsException('No element at position ' . $index);
        }

        return $this->container[$index];
    }

    /**
     * {@inheritdoc}
     */
    public function tryGet($index, $default = null)
    {
        if ($this->containsKey($index) === false) {
            return $default;
        }

        return $this->get($index);
    }
    
    /**
     * {@inheritdoc}
     */
    public function add($key, $value)
    {
        if ($this->containsKey($key)) {
            throw new KeyException('The key ' . $key . ' already exists!');
        }

        $this->set($key, $value);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addAll($items)
    {
        $this->validateTraversable($items);

        foreach ($items as $key => $value) {
            if (is_array($value)) {
                $value = new static($value);
            }
            $this->add($key, $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setAll($items)
    {
        $this->validateTraversable($items);

        foreach ($items as $key => $item) {
            if (is_array($item)) {
                $item = new static($item);
            }
            $this->set($key, $item);
        }

        return $this;
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
        $key = array_search($element, $this->container);

        if (false === $key) {
            throw new \OutOfBoundsException('No element found in the collection ');
        }

        $this->removeKey($key);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeKey($key)
    {
        if ($this->containsKey($key) === false) {
            throw new \OutOfBoundsException('No element at position ' . $key);
        }

        unset($this->container[$key]);

        return $this;
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

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function concat($iterable)
    {
        $this->validateTraversable($iterable);

        $this->setAll($this->concatRecurse($this, $iterable));

        return $this;
    }
}
