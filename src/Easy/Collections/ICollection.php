<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

use Countable;

/**
 * Provides functionality to evaluate queries against a specific data source wherein the type of the data is not specified.
 */
interface ICollection extends IEnumerable, Countable
{

    /**
     * Removes all elements from the ICollection object.
     * @return CollectionArray
     */
    public function clear();

    /**
     * Verifies whether a colletion is empty
     * @return boolean
     */
    public function isEmpty();

    /**
     * Determines whether the IDictionary object contains an element with the specified key.
     * @param mixed $item The key to locate in the IDictionary object.
     * @return boolean
     */
    public function contains($item);

    /**
     * Gets an ICollection object containing the values in the IDictionary object.
     */
    public function values();

    /**
     * Gets or sets the element with the specified key.
     * @param mixed $key The key of the element to get or set.
     */
    public function get($key);

    /**
     * Gets the value associated with the specified key.
     * @param mixed $index The key of the value to get.
     * @return When this method returns, contains the value associated with the 
     * specified key, if the key is found; otherwise, the default value for the 
     * type of the value parameter. This parameter is passed uninitialized.
     */
    public function tryGet($index);

    /**
     * Removes the IList item at the specified index.
     * @param int $element The zero-based index of the item to remove.
     * @return boolean
     */
    public function removeValue($element);

    /**
     * Removes the element with the specified key from the IList object.
     * @param mixed $index The key of the element to remove.
     * @return CollectionArray
     */
    public function remove($index);
}
