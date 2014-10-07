<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Easy\Collections\Rx;

use Closure;
use Easy\Collections\CollectionInterface;

/**
 * Provides functionality to evaluate queries against a specific data source wherein the type of the data is not specified.
 */
interface FilterInterface
{

    /**
     * Returns all the elements of this collection that satisfy the predicate p.
     * The order of the elements is preserved.
     *
     * @param Closure $p The predicate used for filtering.
     *
     * @return CollectionInterface A collection with the results of the filter operation.
     */
    public function filter(Closure $p);

    /**
     * Returns all the elements of this collection that satisfy the predicate p.
     * The order of the elements is preserved.
     *
     * @param callable $p The predicate used for map.
     *
     * @return CollectionInterface A collection with the results of the filter operation.
     */
    public function map($p);

    /**
     * Returns all the elements of this collection that satisfy the predicate p.
     * The order of the elements is preserved.
     *
     * @param callable $p The predicate used for map.
     *
     * @return CollectionInterface A collection with the results of the filter operation.
     */
    public function flatMap($p);

    /**
     * Returns the first element of an observable sequence that satisfies the condition in the predicate if present else the first item in the sequence.
     *
     * @return CollectionInterface A collection with the results of the filter operation.
     */
    public function first();

    /**
     * Returns the last element of an observable sequence that satisfies the condition in the predicate if specified, else the last element.
     *
     * @return CollectionInterface A collection with the results of the filter operation.
     */
    public function last();

    /**
     * Returns a specified number of contiguous elements from the start of an observable sequence, using the specified scheduler for the edge case of take(0).
     *
     * @param integer $count The number of elements to take.
     *
     * @return CollectionInterface A collection with the results of the filter operation.
     */
    public function take($count);

    /**
     * Slice the elements of this Collection in place
     * @param int $offset
     * @param int $length
     * @return CollectionInterface
     * @deprecated
     */
    public function slice($offset, $length = null);
}
