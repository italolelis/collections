<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Easy\Collections;

use InvalidArgumentException;
use OutOfBoundsException;
use Traversable;

/**
 * Represents a collection of keys and values.
 */
class Dictionary extends CollectionArray implements MapInterface, MapConvertableInterface
{

    public function __construct($array = null)
    {
        if ($array !== null) {
            $this->addAll($array);
        }
    }

    public function hashCode($object)
    {
        return spl_object_hash($object);
    }

    /**
     * {@inheritdoc}
     */
    public function add($key, $value)
    {
        if ($this->containsKey($key)) {
            throw new InvalidArgumentException('The key ' . $key . ' already exists!');
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
        if ($key === null) {
            throw new InvalidArgumentException("Can't use 'null' as key!");
        }

        $this->offsetSet($key, $value);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        if (is_object($offset)) {
            $offset = $this->hashCode($offset);
        }

        return isset($this->array[$offset]) || array_key_exists($offset, $this->array);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        if ($this->containsKey($offset) === false) {
            throw new OutOfBoundsException('No element at position ' . $offset);
        }

        if (is_object($offset)) {
            $offset = $this->hashCode($offset);
        }

        return $this->array[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if (is_object($offset)) {
            $offset = $this->hashCode($offset);
        }

        $this->array[$offset] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        if ($this->containsKey($offset) === false) {
            throw new InvalidArgumentException('The key ' . $offset . ' is not present in the dictionary');
        }

        unset($this->array[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function toList()
    {
        return new ArrayList($this->array);
    }

    /**
     * {@inheritdoc}
     */
    public static function fromArray(array $arr)
    {
        $map = new Dictionary();
        foreach ($arr as $k => $v) {
            if (is_array($v)) {
                $map->add($k, new Dictionary($v));
            } else {
                $map->add($k, $v);
            }
        }
        return $map;
    }
}
