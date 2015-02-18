<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

use Traversable;

/**
 * Represents a non-generic collection of objects that can be individually accessed by index.
 */
interface VectorInterface extends CollectionInterface, IndexAccessInterface, ConstIndexAccessInterface
{

    /**
     * Adds an item to the IList.
     * @param mixed $item The object to add to the IList.
     * @return VectorInterface
     */
    public function add($item);

    /**
     * Inserts an item to the IList at the specified index.
     * @param int $index The zero-based index at which value should be inserted.
     * @param mixed $item The object to insert into the IList.
     * @return VectorInterface
     */
    public function insert($index, $item);

    /**
     * Determines the index of a specific item in the IList.
     * @param mixed $item The object to locate in the IList.
     */
    public function indexOf($item);

    /**
     * Splice the Vector in place. This function provides the functional equivalent of array_splice(), but for Vectors.
     * @param int $offset
     * @param int $length
     * @return VectorInterface
     */
    public function splice($offset, $length = null);

    /**
     * Reverses the elements of this Vector in place
     * @return void
     */
    public function reverse();
}
