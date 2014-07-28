<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Easy\Collections;

use ArrayIterator;
use Easy\Collections\Comparer\NumericKeyComparer;
use Easy\Collections\Generic\IComparer;
use Easy\Generics\IEquatable;

/**
 * Provides the abstract base class for a strongly typed collection.
 */
abstract class AbstractCollection implements ICollection, ICollectionConvertable,
    IEquatable
{
    protected $array = array();

    /**
     * @var IComparer
     */
    private $defaultComparer;

    public function getIterator()
    {
        return new ArrayIterator($this->array);
    }

    /**
     * Gets the default comparer for this collection
     * @return IComparer
     */
    public function getDefaultComparer()
    {
        if ($this->defaultComparer === null) {
            $this->defaultComparer = new NumericKeyComparer();
        }
        return $this->defaultComparer;
    }

    /**
     * Sets the default comparer for this collection
     * @param IComparer $defaultComparer
     * @return ArrayList
     */
    public function setDefaultComparer(IComparer $defaultComparer)
    {
        $this->defaultComparer = $defaultComparer;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->toArray());
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->array = array();
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty()
    {
        return $this->count() < 1;
    }

    /**
     * {@inheritdoc}
     */
    public function values()
    {
        return array_values($this->array);
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize($this->array);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $this->array = unserialize($serialized);
        return $this->array;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return get_class($this);
    }

    public function equals($obj)
    {
        return ($obj === $this);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $array = array();
        foreach ($this->array as $key => $value) {
            if ($value instanceof ICollection) {
                $array[$key] = $value->toArray();
            } else {
                $array[$key] = $value;
            }
        }
        return $array;
    }

    /**
     * {@inheritdoc}
     */
    public function toKeysArrays()
    {
        return array_keys($this->array);
    }

    /**
     * {@inheritdoc}
     */
    public function concat(ICollectionConvertable $collection)
    {
        $this->array = array_merge_recursive($this->array,
                                             $collection->toArray());
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public static function fromItems(Traversable $items)
    {
        return new static($items);
    }
}