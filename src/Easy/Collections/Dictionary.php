<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

use InvalidArgumentException;
use Traversable;

/**
 * Represents a collection of keys and values.
 */
class Dictionary extends CollectionArray implements IDictionary, IDictionaryConvertable
{

    public function __construct(Traversable $array = null)
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
        if ($this->contains($key)) {
            throw new InvalidArgumentException('That key already exists!');
        }
        $this->set($key, $value);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addAll(Traversable $items)
    {
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
        return $this->contains($offset);
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
                $map->add($k, new ArrayList($v));
            } else {
                $map->add($map, $v);
            }
        }
        return $map;
    }

    /**
     * {@inheritdoc}
     */
    public static function fromItems(Traversable $items)
    {
        return new ArrayList($items);
    }

    public static function getFromArray($arr)
    {
        return Dictionary::fromArray($arr);
    }

}
