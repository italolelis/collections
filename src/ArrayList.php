<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

use Collections\Iterator\ArrayIterator;
use Collections\Traits\StrictIterableTrait;
use InvalidArgumentException;
use Traversable;

/**
 * Represents a strongly typed list of objects that can be accessed by index. Provides methods to search, sort,
 * and manipulate lists.
 */
class ArrayList extends AbstractCollectionArray implements VectorInterface, \ArrayAccess
{
    use StrictIterableTrait,
        GuardTrait;

    public function at($key)
    {
        $this->validateKeyType($key);
        $this->validateKeyBounds($key);

        return $this->container[$key];
    }

    public function set($key, $value)
    {
        $this->validateKeyType($key);
        $this->container[$key] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function get($index)
    {
        $this->validateKeyType($index);

        return $this->container[$index];
    }

    /**
     * {@inheritdoc}
     */
    public function add($item)
    {
        $this->container[] = $item;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addAll($items)
    {
        if (!is_array($items) && !$items instanceof Traversable) {
            throw new \InvalidArgumentException('Parameter must be an array or an instance of Traversable');
        }

        foreach ($items as $item) {
            if (is_array($item)) {
                $item = new static($item);
            }
            $this->add($item);
        }

        return $this;
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
    public function removeKey($key)
    {
        $this->validateKeyType($key);
        $this->validateKeyBounds($key);

        array_splice($this->container, $key, 1);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function indexOf($item)
    {
        return array_search($item, $this->container, true);
    }

    /**
     * {@inheritdoc}
     */
    public function insert($index, $item)
    {
        if (!is_numeric($index)) {
            throw new InvalidArgumentException('The index must be numeric');
        }
        if ($index < 0 || $index >= $this->count()) {
            throw new InvalidArgumentException('The index is out of bounds (must be >=0 and <= size of te array)');
        }

        $current = $this->count() - 1;
        for (; $current >= $index; $current--) {
            $this->container[$current + 1] = $this->container[$current];
        }
        $this->container[$index] = $item;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        $this->validateKeyType($offset);

        return $this->containsKey($offset) && $this->at($offset) !== null;
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
            $this->add($value);
        } else {
            $this->set($offset, $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        throw new \RuntimeException(
            'Cannot unset an element of a ' . get_class($this));
    }

    /**
     * {@inheritdoc}
     */
    public function toMap()
    {
        return new Dictionary($this->getIterator());
    }

    /**
     * {@inheritdoc}
     */
    public function reverse()
    {
        return static::fromArray(array_reverse($this->container));
    }

    /**
     * {@inheritdoc}
     */
    public function splice($offset, $length = null)
    {
        return static::fromArray(array_splice($this->container, $offset, $length));
    }

    /**
     * {@inheritdoc}
     */
    public static function fromArray(array $arr)
    {
        $map = new ArrayList();
        foreach ($arr as $v) {
            if (is_array($v)) {
                $map->add(new ArrayList($v));
            } else {
                $map->add($v);
            }
        }

        return $map;
    }

    /**
     * Gets the collection's iterator
     * @return \Iterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->container);
    }
}
