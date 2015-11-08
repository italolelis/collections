<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

/**
 * Represents a nongeneric collection of key/value pairs.
 */
interface MapInterface extends
    ConstMapInterface,
    CollectionInterface,
    MapAccessInterface
{
    /**
     * Adds an element with the provided key and value to the IDictionary object.
     * @param mixed $key The Object to use as the key of the element to add.
     * @param mixed $value The Object to use as the value of the element to add.
     * @return MapInterface
     */
    public function add($key, $value);
}
