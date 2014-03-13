<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

use Easy\Collections\CollectionArray;
use InvalidArgumentException;

/**
 * Represents a strongly typed list of objects that can be accessed by index. Provides methods to search, sort, and manipulate lists.
 */
class ArrayList extends CollectionArray implements IList
{

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
        $this->addMultiple($items);
        return $this;
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
        return array_key_exists((int) $offset, $this->array);
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
        if (!is_numeric($offset)) {
            throw new InvalidArgumentException('The offset value must be numeric');
        }
        if ($offset < 0) {
            throw new InvalidArgumentException('The option value must be a number > 0');
        }
        $this->array[(int) $offset] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

}
