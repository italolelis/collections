<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

use Easy\Collections\Generic\ComparerInterface;
use InvalidArgumentException;

class Dictionary extends CollectionBase implements DictionaryInterface
{

    /**
     * @inheritdoc
     */
    public function offsetExists($offset)
    {
        return $this->contains($offset);
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset) == false) {
            throw new InvalidArgumentException(__('The key is not present in the dictionary'));
        }
        return $this->getItem($offset);
    }

    /**
     * @inheritdoc
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    /**
     * @inheritdoc
     */
    public function add($key, $value)
    {
        if ($this->contains($key)) {
            throw new InvalidArgumentException(__('That key already exists!'));
        }
        $this->set($key, $value);
    }

    public function set($key, $value)
    {
        if ($key === null) {
            throw new InvalidArgumentException(__("Can't use 'null' as key!"));
        }
        $this->array[$key] = $value;
    }

    /**
     * @inheritdoc
     */
    public function remove($key)
    {
        if ($this->contains($key) == false) {
            throw new InvalidArgumentException(__('The key is not present in the dictionary'));
        }
        unset($this->array[$key]);
    }

    /**
     * @inheritdoc
     */
    public function keys()
    {
        return array_keys($this->array);
    }

    /**
     * @inheritdoc
     */
    public function values()
    {
        return array_values($this->array);
    }

    /**
     * @inheritdoc
     */
    public function getItem($key)
    {
        return $this->array[$key];
    }

    /**
     * Sorts the elements in the entire Dictonary<T> using the specified comparer.
     * @param ComparerInterface $comparer The ComparerInterface implementation to use when comparing elements, or null to use the default comparer Comparer<T>.Default.
     */
    public function sort(ComparerInterface $comparer = null)
    {
        if ($comparer === null) {
            $comparer = $this->getDefaultComparer();
        }
        uasort($this->array, array($comparer, 'compare'));
    }

}