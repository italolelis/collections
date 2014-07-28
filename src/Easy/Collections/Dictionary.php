<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Easy\Collections;

use InvalidArgumentException;
use Traversable;

/**
 * Represents a collection of keys and values.
 */
class Dictionary extends CollectionArray implements IMap, IMapConvertable
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
        $this->array[$key] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return $this->containsKey($offset);
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
        $this->set($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
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