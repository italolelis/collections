<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

/**
 * Represents a nongeneric collection of key/value pairs.
 */
interface DictionaryInterface extends CollectionInterface
{

    /**
     * Adds an element with the provided key and value to the IDictionary object.
     * @param mixed $key The Object to use as the key of the element to add.
     * @param mixed $value The Object to use as the value of the element to add.
     */
    public function add($key, $value);

    /**
     * Removes the element with the specified key from the IDictionary object.
     * @param mixed $key The key of the element to remove.
     */
    public function remove($key);

    /**
     * Gets an ICollection object containing the keys of the IDictionary object.
     */
    public function keys();

    /**
     * Gets an ICollection object containing the values in the IDictionary object.
     */
    public function values();

    /**
     * Gets or sets the element with the specified key.
     * @param mixed $key The key of the element to get or set.
     */
    public function getItem($key);
}