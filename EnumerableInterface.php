<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

use ArrayAccess;
use IteratorAggregate;
use Serializable;

/**
 * Exposes the enumerator, which supports a simple iteration over a non-generic collection.
 */
interface EnumerableInterface extends IteratorAggregate, ArrayAccess, Serializable
{

    /**
     * Gets the elements for IEnumerable object
     */
    public function getArray();
}
