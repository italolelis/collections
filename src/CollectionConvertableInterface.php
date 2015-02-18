<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

/**
 * Provides functionality to convert the collection into any ICollection
 */
interface CollectionConvertableInterface
{

    /**
     * Return an array containing the values from this CollectionInterface.
     * @return array
     */
    public function toArray();

    /**
     * Returns a Map containing the key/value pairs from the specified array.
     * @return MapInterface Returns a Map containing the key/value pairs from the specified array.
     */
    public static function fromArray(array $arr);
}
