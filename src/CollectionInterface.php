<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

use IteratorAggregate;
use Serializable;

/**
 * Provides functionality to evaluate queries against a specific data source wherein the type of the data is not
 * specified.
 */
interface CollectionInterface extends
    ConstCollectionInterface,
    OutputCollectionInterface,
    Serializable,
    IteratorAggregate
{
    /**
     * Clear all of the elements in the collection
     * @return void
     */
    public function clear();
}
