<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

/**
 * Provides functionality to evaluate queries against a specific data source wherein the type of the data is not
 * specified.
 */
interface CollectionInterface extends
    ConstCollectionInterface,
    OutputCollectionInterface
{
    /**
     * Removes all items from the collection.
     * @return void
     */
    public function clear();
}
