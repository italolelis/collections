<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

/**
 * Provides functionality to convert the collection into any IList
 */
interface IVectorConvertable
{

    /**
     * Returns a Map of the ICollection, with the integer indicies of the 
     * ICollection as the keys and the values of the ICollection as the values.
     * @return IMap
     */
    public function toMap();

    /**
     * Returns another ICollection based on this ICollection.
     * @return IVector
     */
    public function toList();

    /**
     * Returns a Vector containing the key/value pairs from the specified array.
     * @return IMap Returns a Map containing the key/value pairs from the specified array.
     */
    public static function fromArray(array $arr);

    /**
     * Returns a Vector containing the items from the specified Traversable.
     * @return IMap Returns a Vector containing the key/value pairs from the specified Traversable.
     */
    public static function fromItems(\Traversable $items);
}
