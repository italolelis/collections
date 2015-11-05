<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

use Collections\Exception\KeyException;
use InvalidArgumentException;
use OutOfBoundsException;
use Traversable;

/**
 * Represents a collection of keys and values.
 */
class Dictionary extends AbstractCollectionArray implements MapInterface, MapConvertableInterface
{
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

    public function set($key, $value)
    {
        $this->offsetSet($key, $value);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->storage[$offset]) || array_key_exists($offset, $this->storage);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        if ($this->containsKey($offset) === false) {
            throw new OutOfBoundsException('No element at position ' . $offset);
        }

        return $this->storage[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            throw new InvalidArgumentException("Can't use 'null' as key!");
        }

        $this->storage[$offset] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        if ($this->containsKey($offset) === false) {
            throw new InvalidArgumentException('The key ' . $offset . ' is not present in the dictionary');
        }

        unset($this->storage[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public static function fromArray(array $arr)
    {
        $map = new static();
        foreach ($arr as $k => $v) {
            if (is_array($v)) {
                $map->add($k, new static($v));
            } else {
                $map->add($k, $v);
            }
        }

        return $map;
    }

    /**
     * {@inheritdoc}
     */
    public function toList()
    {
        return new ArrayList($this->getIterator());
    }
}
