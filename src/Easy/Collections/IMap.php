<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

use Traversable;

/**
 * Represents a nongeneric collection of key/value pairs.
 */
interface IMap extends ICollection, IIndexAccess, IConstIndexAccess
{

    /**
     * Adds an element with the provided key and value to the IDictionary object.
     * @param mixed $key The Object to use as the key of the element to add.
     * @param mixed $value The Object to use as the value of the element to add.
     * @return Dictionary
     */
    public function add($key, $value);

    /**
     * Adds all the key/value Pairs from the Traversable to the IDictionary.
     * @param Traversable $items The collection whose elements should be added to the end of the IDictionary.
     * @return IMap
     */
    public function addAll($items);
}
