<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

/**
 * Represents a non-generic collection of objects that can be individually accessed by index.
 */
interface VectorInterface extends
    ConstVectorInterface,
    CollectionInterface,
    IndexAccessInterface
{
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
     * Reverses the elements of this vector in place
     * @return void
     */
    public function reverse();
}
