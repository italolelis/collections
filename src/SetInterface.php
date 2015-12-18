<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

/**
 * Represents a write-enabled (mutable) set of values, not indexed by keys
 * (i.e. a set).
 */
interface SetInterface extends
    ConstSetInterface,
    CollectionInterface,
    SetAccessInterface
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
}
