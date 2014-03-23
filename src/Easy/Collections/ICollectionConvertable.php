<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

use Countable;

/**
 * Provides functionality to convert the collection into any ICollection
 */
interface ICollectionConvertable
{

    /**
     * Return an array containing the values from this ICollection.
     * @return array
     */
    public function toArray();

    /**
     * Returns an array whose values are the keys from the ICollection.
     * @return array
     */
    public function toKeysArrays();
}
