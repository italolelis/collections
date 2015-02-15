<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Easy\Collections\Rx;

use Closure;

/**
 * Provides functionality to evaluate queries against a specific data source wherein the type of the data is not specified.
 */
interface ReactiveExtensionInterface extends FilterableInterface, IterableInterface, AggregatableInterface
{

    /**
     * Tests for the existence of an element that satisfies the given predicate.
     *
     * @param Closure $p The predicate.
     *
     * @return boolean True if the predicate is True for at least one element, False otherwise.
     */
    public function exists(Closure $p);

}
