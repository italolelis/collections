<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

/**
 * Represents a write-enabled (mutable) sequence of values, indexed by integers
 * (i.e., a vector).
 */
interface VectorInterface extends
    ConstVectorInterface,
    CollectionInterface,
    IndexAccessInterface
{
    /**
     * Add a value to the collection and return the collection itself.
     *
     * It returns a shallow copy of the current collection, meaning changes
     * made to the current collection will be reflected in the returned
     * collection.
     *
     * @param mixed $item - The value to add.
     * @return $this - A shallow copy of the updated current collection itself.
     */
    public function add($item);

    /**
     * Inserts an item to the VectorInterface at the specified index.
     * @param int $index The zero-based index at which value should be inserted.
     * @param mixed $item The object to insert into the VectorInterface.
     * @return VectorInterface
     */
    public function insert($index, $item);

    /**
     * Determines the index of a specific item in the VectorInterface.
     * @param mixed $item The object to locate in the VectorInterface.
     */
    public function indexOf($item);

    /**
     * Reverses the elements of this vector in place
     * @return void
     */
    public function reverse();

    /**
     * Reduce the vector to a single value.
     *
     * @param  callable  $callback
     * @param  mixed     $initial
     * @return self
     */
    public function reduce(callable $callback, $initial = null);
}
