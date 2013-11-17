<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

use InvalidArgumentException;

/**
 * Represents a collection of keys and values.
 */
class Dictionary extends CollectionArray implements IDictionary
{

    /**
     * {@inheritdoc}
     */
    public function add($key, $value)
    {
        if ($this->contains($key)) {
            throw new InvalidArgumentException('That key already exists!');
        }
        $this->set($key, $value);
    }

    public function set($key, $value)
    {
        if ($key === null) {
            throw new InvalidArgumentException("Can't use 'null' as key!");
        }
        $this->array[$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function keys()
    {
        return array_keys($this->array);
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
        if ($this->offsetExists($offset) == false) {
            throw new InvalidArgumentException('The key is not present in the dictionary');
        }
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

}
