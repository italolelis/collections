<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Easy\Collections\Iterator;

use Easy\Collections\CollectionInterface;
use IteratorIterator;

/**
 * This iterator will insert values into a property of each of the records returned.
 * The values to be inserted come out of another traversal object. This is useful
 * when you have two separate collections and want to merge them together by placing
 * each of the values from one collection into a property inside the other collection.
 */
class InsertIterator extends IteratorIterator
{
    /**
     * The collection from which to extract the values to be inserted
     *
     * @var CollectionInterface
     */
    protected $values;
    /**
     * Holds whether the values collection is still valid. (has more records)
     *
     * @var bool
     */
    protected $validValues = true;
    /**
     * An array containing each of the properties to be traversed to reach the
     * point where the values should be inserted.
     *
     * @var array
     */
    protected $path;
    /**
     * The property name to which values will be assigned
     *
     * @var string
     */
    protected $target;

    /**
     * Constructs a new collection that will dynamically add properties to it out of
     * the values found in $values.
     *
     * @param array|\Traversable $into The target collection to which the values will
     * be inserted at the specified path.
     * @param string $path A dot separated list of properties that need to be traversed
     * to insert the value into the target collection.
     * @param array|\Traversable $values The source collection from which the values will
     * be inserted at the specified path.
     */
    public function __construct($into, $path, $values)
    {
        parent::__construct($into);
        $path = explode('.', $path);
        $target = array_pop($path);
        $this->path = $path;
        $this->target = $target;
        $this->values = $values;
    }

    /**
     * Advances the cursor to the next record
     *
     * @return void
     */
    public function next()
    {
        parent::next();
        if ($this->validValues) {
            $this->values->next();
        }
        $this->validValues = $this->values->valid();
    }

    /**
     * Returns the current element in the target collection after inserting
     * the value from the source collection into the specified path.
     *
     * @return void
     */
    public function current()
    {
        $row = parent::current();
        if (!$this->validValues) {
            return $row;
        }
        $pointer =& $row;
        foreach ($this->path as $step) {
            if (!isset($pointer[$step])) {
                return $row;
            }
            $pointer =& $pointer[$step];
        }
        $pointer[$this->target] = $this->values->current();
        return $row;
    }

    /**
     * Resets the collection pointer.
     *
     * @return void
     */
    public function rewind()
    {
        parent::rewind();
        $this->values->rewind();
        $this->validValues = $this->values->valid();
    }
}