<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

/**
 * Represents a reactive extension.
 */
interface RxInterface
{
    /**
     * {@inheritDoc}
     *
     */
    public function each(callable $callable);

    /**
     * {@inheritDoc}
     *
     * @return CollectionInterface
     */
    public function filter(callable $callable);

    /**
     * {@inheritDoc}
     *
     * @return CollectionInterface
     */
    public function map(callable $c);

    /**
     * {@inheritDoc}
     *
     * @return CollectionInterface
     */
    public function reject(callable $callable);

    /**
     * {@inheritDoc}
     *
     */
    public function every(callable $callable);

    /**
     * {@inheritDoc}
     *
     */
    public function some(callable $callable);

    /**
     * Iteratively reduce the collection to a single value using a callback function.
     *
     * @param callable $callable The callable used for reduce.
     * @param int $zero If the optional initial is available, it will be used at the beginning of the process,
     * or as a final result in case the array is empty.
     * @return CollectionInterface A collection with the results of the filter operation.
     */
    public function reduce(callable $callable, $zero = null);

    /**
     * @param $matcher
     * @return CollectionInterface
     */
    public function extract($matcher);

    /**
     * {@inheritDoc}
     *
     */
    public function sample($size = 10);

    /**
     * {@inheritDoc}
     *
     */
    public function take($size = 1, $from = 0);

    /**
     * {@inheritDoc}
     *
     */
    public function match(array $conditions);

    /**
     * {@inheritDoc}
     *
     */
    public function firstMatch(array $conditions);

    /**
     * {@inheritDoc}
     */
    public function insert($path, $values);

    /**
     * {@inheritDoc}
     *
     */
    public function first();

    /**
     * Returns the last element of an observable sequence that satisfies the condition in the predicate if specified,
     * else the last element.
     *
     * @return CollectionInterface A collection with the results of the filter operation.
     */
    public function last();

    /**
     * {@inheritDoc}
     *
     */
    public function unfold(callable $transformer = null);

    /**
     * {@inheritdoc}
     */
    public function shuffle();

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function groupBy($callback);
}
