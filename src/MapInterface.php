<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

/**
 * Represents a nongeneric collection of key/value pairs.
 */
interface MapInterface extends CollectionInterface, IndexAccessInterface, ConstIndexAccessInterface
{

    /**
     * Adds an element with the provided key and value to the IDictionary object.
     * @param mixed $key The Object to use as the key of the element to add.
     * @param mixed $value The Object to use as the value of the element to add.
     * @return Dictionary
     */
    public function add($key, $value);

    /**
     * Store a value into the Map with the specified key, overwriting a previous value if already present.
     *
     * @param $key
     * @param mixed $value
     *
     * @return void
     */
    public function set($key, $value);
}
