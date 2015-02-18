<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

use ArrayIterator;
use Collections\Comparer\NumericKeyComparer;
use Collections\Generic\ComparerInterface;
use Easy\Generics\EquatableInterface;

/**
 * Provides the abstract base class for a strongly typed collection.
 */
abstract class AbstractCollection implements CollectionInterface, EquatableInterface
{
    /**
     * @var array
     */
    protected $array = array();

    /**
     * @var ComparerInterface
     */
    private $defaultComparer;

    /**
     * @var \Iterator
     */
    private $iterator;

    /**
     * Gets the collection's iterator
     * @return \Iterator
     */
    public function getIterator()
    {
        if (!$this->iterator) {
            $this->iterator = new ArrayIterator($this->array);
        }

        return $this->iterator;
    }

    /**
     * Sets the collection's iterator
     * @param \Iterator $iterator
     * @return CollectionInterface
     */
    public function setIterator(\Iterator $iterator)
    {
        $this->iterator = $iterator;
        return $this;
    }

    /**
     * Gets the default comparer for this collection
     * @return ComparerInterface
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
     * @param ComparerInterface $defaultComparer
     * @return CollectionInterface
     */
    public function setDefaultComparer(ComparerInterface $defaultComparer)
    {
        $this->defaultComparer = $defaultComparer;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->array);
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->array = [];
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
    public function concat(CollectionConvertableInterface $collection)
    {
        $this->array = array_merge($this->array, $collection->toArray());
        return $this;
    }

}
