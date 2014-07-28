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
     * Checks whether the collection contains an element with the specified key/index.
     *
     * @param string|integer $key The key/index to check for.
     * @return boolean TRUE if the collection contains an element with the specified key/index,
     *                 FALSE otherwise.
     */
    public function containsKey($key);

    /**
     * Gets or sets the element with the specified key.
     * @param mixed $key The key of the element to get or set.
     */
    public function get($key);

    /**
     * Gets the value associated with the specified key.
     * @param mixed $index The key of the value to get.
     * @param mixed $default The default value which is returned if the key doesn't exists.
     * @return mixed When this method returns, contains the value associated with the 
     * specified key, if the key is found; otherwise, the default value for the 
     * type of the value parameter. This parameter is passed uninitialized.
     */
    public function tryGet($index, $default = null);
}