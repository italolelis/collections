<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Easy\Collections;

use Traversable;

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

    /**
     * Returns a Map containing the key/value pairs from the specified array.
     * @return IMap Returns a Map containing the key/value pairs from the specified array.
     */
    public static function fromArray(array $arr);

    /**
     * Returns a Map containing the key/value pairs from the specified Traversable.
     * @return IMap Returns a Map containing the key/value pairs from the specified Traversable.
     */
    public static function fromItems(Traversable $items);
}