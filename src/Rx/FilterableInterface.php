<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections\Rx;

use Collections\CollectionInterface;

/**
 * Provides functionality to evaluate queries against a specific data source wherein the type of the data
 * is not specified.
 */
interface FilterableInterface
{

    /**
     * Returns all the elements of this collection that satisfy the predicate p.
     * The order of the elements is preserved.
     *
     * @param callable $c The callable used for filtering.
     * @return CollectionInterface A collection with the results of the filter operation.
     */
    public function filter(callable $c);

    /**
     * Looks through each value in the collection, and returns another collection with
     * all the values that do not pass a truth test. This is the opposite of `filter`.
     *
     * Each time the callback is executed it will receive the value of the element
     * in the current iteration, the key of the element and this collection as
     * arguments, in that order.
     *
     * @param callable $c the method that will receive each of the elements and
     * returns true whether or not they should be out of the resulting collection.
     * @return CollectionInterface
     */
    public function reject(callable $c);

    /**
     * Returns true if all values in this collection pass the truth test provided
     * in the callback.
     *
     * Each time the callback is executed it will receive the value of the element
     * in the current iteration and  the key of the element as arguments, in that
     * order.
     *
     * @param callable $c a callback function
     * @return bool true if for all elements in this collection the provided
     * callback returns true, false otherwise
     */
    public function every(callable $c);

    /**
     * Returns true if any of the values in this collection pass the truth test
     * provided in the callback.
     *
     * Each time the callback is executed it will receive the value of the element
     * in the current iteration and the key of the element as arguments, in that
     * order.
     *
     * @param callable $c a callback function
     * @return bool true if for all elements in this collection the provided
     * callback returns true, false otherwise
     */
    public function some(callable $c);

    /**
     * Looks through each value in the list, returning a Collection of all the
     * values that contain all of the key-value pairs listed in $conditions.
     *
     * @param array $conditions a key-value list of conditions where
     * the key is a property path as accepted by `Collection::extract,
     * and the value the condition against with each element will be matched
     * @return CollectionInterface
     */
    public function match(array $conditions);

    /**
     * Returns the first result matching all of the key-value pairs listed in
     * conditions.
     *
     * @param array $conditions a key-value list of conditions where the key is
     * a property path as accepted by `Collection::extract`, and the value the
     * condition against with each element will be matched
     * @return mixed
     */
    public function firstMatch(array $conditions);
}
