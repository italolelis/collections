<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

/**
 * Allows for access key-based collections with methods such as indexOf().
 */
interface ConstIndexAccessInterface
{
    /**
     * Returns the value at the specified key in the current collection.
     * @param string|int $key the key from which to retrieve the value.
     * @return mixed The value at the specified key; or an exception if the key does not exist.
     */
    public function at($key);

    /**
     * Checks whether the collection contains an element with the specified key/index.
     * If the key is not present, null is returned. If you would rather have an exception thrown
     * when a key is not present, then use `at()`.
     *
     * @param string|int $key The key/index to check for.
     * @return bool - true if the specified key is present in the current collection; false otherwise.
     */
    public function containsKey($key);

    /**
     * Returns the value at the specified key in the current collection.
     * @param mixed $key The key of the element to get or set.
     */
    public function get($key);
}
