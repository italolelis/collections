<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Easy\Collections\Rx;

use Closure;
use Easy\Collections\CollectionInterface;

/**
 * Provides functionality to evaluate queries against a specific data source wherein the type of the data is not specified.
 */
interface ReactiveExtensionInterface extends FilterInterface
{

    /**
     * Tests for the existence of an element that satisfies the given predicate.
     *
     * @param Closure $p The predicate.
     *
     * @return boolean True if the predicate is True for at least one element, False otherwise.
     */
    public function exists(Closure $p);

    /**
     * Iteratively reduce the collection to a single value using a callback function.
     *
     * @param callable $p The predicate used for reduce.
     * @param int $initial If the optional initial is available, it will be used at the beginning of the process, or as a final result in case the array is empty.
     * @return CollectionInterface A collection with the results of the filter operation.
     */
    public function reduce($p, $initial = null);
}
