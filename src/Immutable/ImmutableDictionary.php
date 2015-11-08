<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

use Collections\Exception\KeyException;
use InvalidArgumentException;
use OutOfBoundsException;
use Traversable;

/**
 * Represents a collection of keys and values.
 */
final class ImmutableDictionary implements ConstCollectionInterface, ConstMapAccessInterface
{

    /**
     * Checks whether the collection contains an element with the specified key/index.
     *
     * @param string|integer $key The key/index to check for.
     * @return bool TRUE if the collection contains an element with the specified key/index,
     *                 FALSE otherwise.
     */
    public function containsKey($key)
    {
        // TODO: Implement containsKey() method.
    }

    /**
     * Gets or sets the element with the specified key.
     * @param mixed $key The key of the element to get or set.
     */
    public function get($key)
    {
        // TODO: Implement get() method.
    }

    /**
     * Gets the value associated with the specified key.
     * @param mixed $index The key of the value to get.
     * @param string|null $default The default value which is returned if the key doesn't exists.
     * @return mixed When this method returns, contains the value associated with the
     * specified key, if the key is found; otherwise, the default value for the
     * type of the value parameter. This parameter is passed uninitialized.
     */
    public function tryGet($index, $default = null)
    {
        // TODO: Implement tryGet() method.
    }

    /**
     * Determines whether the collection object contains an element with the specified key.
     * @param mixed $item The key to locate in the collection object.
     * @return bool
     */
    public function contains($item)
    {
        // TODO: Implement contains() method.
    }

    /**
     * Verifies whether a collection is empty
     * @return bool Returns TRUE if the collection is empty; FASLE otherswise.
     */
    public function isEmpty()
    {
        // TODO: Implement isEmpty() method.
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        // TODO: Implement count() method.
    }
}
