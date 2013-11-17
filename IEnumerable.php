<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

use IteratorAggregate;
use Serializable;

/**
 * Exposes the enumerator, which supports a simple iteration over a non-generic collection.
 */
interface IEnumerable extends IteratorAggregate, Serializable
{

    /**
     * Gets the elements for IEnumerable object
     */
    public function toArray();
}
