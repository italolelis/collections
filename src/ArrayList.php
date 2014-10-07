<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Easy\Collections;

use InvalidArgumentException;
use OutOfBoundsException;
use Traversable;

/**
 * Represents a strongly typed list of objects that can be accessed by index. Provides methods to search, sort, and manipulate lists.
 */
class ArrayList extends CollectionArray implements VectorInterface, VectorConvertableInterface
{

    public function __construct($array = null)
    {
        if ($array !== null) {
            $this->addAll($array);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function add($item)
    {
        array_push($this->array, $item);
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

        foreach ($items as $item) {
            if (is_array($item)) {
                $item = ArrayList::fromArray($item);
            }
            $this->add($item);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function indexOf($item)
    {
        return array_search($item, $this->array, true);
    }

    /**
     * {@inheritdoc}
     */
    public function insert($index, $item)
    {
        if (!is_numeric($index)) {
            throw new InvalidArgumentException('The index must be numeric');
        }
        if ($index < 0 || $index >= $this->Count()) {
            throw new InvalidArgumentException('The index is out of bounds (must be >=0 and <= size of te array)');
        }

        $current = $this->Count() - 1;
        for (; $current >= $index; $current--) {
            $this->array[$current + 1] = $this->array[$current];
        }
        $this->array[$index] = $item;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        if (!is_numeric($offset)) {
            throw new InvalidArgumentException('The offset value must be numeric');
        }
        if ($offset < 0) {
            throw new InvalidArgumentException('The option value must be a number > 0');
        }
        return array_key_exists((int)$offset, $this->array);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        if ($this->containsKey($offset) === false) {
            throw new OutOfBoundsException('No element at position ' . $offset);
        }

        return $this->array[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if (!is_numeric($offset)) {
            throw new InvalidArgumentException('The offset value must be numeric');
        }
        if ($offset < 0) {
            throw new InvalidArgumentException('The option value must be a number > 0');
        }
        $this->array[(int)$offset] = $value;
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
    public function toMap()
    {
        return new Dictionary($this->array);
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
     * {@inheritdoc}
     */
    public function reverse()
    {
        array_reverse($this->array);
    }

    /**
     * {@inheritdoc}
     */
    public function shuffle()
    {
        shuffle($this->array);
    }

    /**
     * {@inheritdoc}
     */
    public function splice($offset, $length = null)
    {
        return ArrayList::fromArray(array_splice($this->array, $offset, $length));
    }
}
