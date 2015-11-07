<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

use Traversable;

/**
 * Represents a non-generic collection of objects that can be individually accessed by index.
 */
interface VectorInterface extends
    CollectionInterface,
    IndexAccessInterface
{
    /**
     * Gets an VectorInterface object containing the values in the VectorInterface object.
     * @return Traversable
     */
    public function values();

    /**
     * Merge the elements of this vector into another
     * @param Traversable $collection
     * @return VectorInterface
     */
    public function concat(Traversable $collection);

    /**
     * Adds an item to the VectorInterface.
     * @param mixed $item The object to add to the VectorInterface.
     * @return VectorInterface
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
     * Splice the vector in place. This function provides the functional equivalent of array_splice(), but for vectors.
     * @param int $start
     * @param int $length
     * @return VectorInterface
     */
    public function splice($start, $length = null);

    /**
     * Reverses the elements of this vector in place
     * @return void
     */
    public function reverse();
}
