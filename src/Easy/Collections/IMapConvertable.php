<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

/**
 * Provides functionality to convert the collection into any IDictionary
 */
interface IMapConvertable
{

    /**
     * Returns another ICollection based on this ICollection.
     * @return IVector
     */
    public function toList();

    /**
     * Returns a Map containing the key/value pairs from the specified array.
     * @return IMap Returns a Map containing the key/value pairs from the specified array.
     */
    public static function fromArray(array $arr);

    /**
     * Returns a Map containing the key/value pairs from the specified Traversable.
     * @return IMap Returns a Map containing the key/value pairs from the specified Traversable.
     */
    public static function fromItems(\Traversable $items);
}
