<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

/**
 * Allows for access key-based collections with methods such as indexOf().
 */
interface IConstIndexAccess
{

    /**
     * Determines whether the ICollection object contains an element with the specified key.
     * @param mixed $item The key to locate in the IDictionary object.
     * @return boolean
     */
    public function contains($item);

    /**
     * Gets or sets the element with the specified key.
     * @param mixed $key The key of the element to get or set.
     */
    public function get($key);

    /**
     * Gets the value associated with the specified key.
     * @param mixed $index The key of the value to get.
     * @return mixed When this method returns, contains the value associated with the 
     * specified key, if the key is found; otherwise, the default value for the 
     * type of the value parameter. This parameter is passed uninitialized.
     */
    public function tryGet($index);
}
