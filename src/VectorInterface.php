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
     * @param  callable $callback
     * @param  mixed $initial
     * @return self
     */
    public function reduce(callable $callback, $initial = null);
}
