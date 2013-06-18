<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

/*
 * Represents a non-generic collection of objects that can be individually accessed by index.
 */
interface ListInterface extends CollectionInterface
{

    /**
     * Adds an item to the IList.
     * @param mixed $item The object to add to the IList.
     */
    public function add($item);

    /**
     * Adds the elements of the specified collection to the end of the IList.
     * @param CollectionInterface|array $items The collection whose elements should be added to the end of the IList.
     */
    public function addRange($items);

    /**
     * Removes the element with the specified key from the IDictionary object.
     * @param mixed $key The key of the element to remove.
     */
    public function remove($key);

    /**
     * Inserts an item to the IList at the specified index.
     * @param int $index The zero-based index at which value should be inserted.
     * @param mixed $item The object to insert into the IList.
     */
    public function insert($index, $item);

    /**
     * Determines the index of a specific item in the IList.
     * @param mixed $item The object to locate in the IList.
     * @param int $start
     * @param int $length
     */
    public function indexOf($item, $start = null, $length = null);

    public function lastIndexOf($item, $start = null, $length = null);

    public function allIndexesOf($item);

    /**
     * Removes the IList item at the specified index.
     * @param int $index The zero-based index of the item to remove.
     */
    public function removeAt($index);

    public function elementAt($index);
}