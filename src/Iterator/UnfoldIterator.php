<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections\Iterator;

use Iterator;
use IteratorIterator;
use RecursiveIterator;
use Traversable;

/**
 * An iterator that can be used to generate nested iterators out of each of
 * applying an function to each of the elements in this iterator.
 *
 */
class UnfoldIterator extends IteratorIterator implements RecursiveIterator
{
    /**
     * A functions that gets passed each of the elements of this iterator and
     * that must return an array or Traversable object.
     *
     * @var callable
     */
    protected $unfolder;

    /**
     * A reference to the internal iterator this object is wrapping.
     *
     * @var Iterator
     */
    protected $innerIterator;

    /**
     * Creates the iterator that will generate child iterators from each of the
     * elements it was constructed with.
     *
     * @param array|\Traversable $items The list of values to iterate
     * @param callable $unfolder A callable function that will receive the
     * current item and key. It must return an array or Traversable object
     * out of which the nested iterators will be yielded.
     */
    public function __construct($items, callable $unfolder)
    {
        $this->unfolder = $unfolder;
        parent::__construct($items);
        $this->innerIterator = $this->getInnerIterator();
    }

    /**
     * Returns true as each of the elements in the array represent a
     * list of items
     *
     * @return bool
     */
    public function hasChildren()
    {
        return true;
    }

    /**
     * Returns an iterator containing the items generated out of transforming
     * the current value with the callable function.
     *
     * @return RecursiveIterator
     */
    public function getChildren()
    {
        $current = $this->current();
        $key = $this->key();
        $unfolder = $this->unfolder;
        return new NoChildrenIterator($unfolder($current, $key, $this->innerIterator));
    }
}