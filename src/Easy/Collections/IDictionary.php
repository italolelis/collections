<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

use ArrayAccess;

/**
 * Represents a nongeneric collection of key/value pairs.
 */
interface IDictionary extends ICollection, ArrayAccess
{

    /**
     * Adds an element with the provided key and value to the IDictionary object.
     * @param mixed $key The Object to use as the key of the element to add.
     * @param mixed $value The Object to use as the value of the element to add.
     * @return Dictionary
     */
    public function add($key, $value);

    /**
     * Gets an ICollection object containing the keys of the IDictionary object.
     */
    public function keys();
}
