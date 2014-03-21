<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

use ArrayAccess;

/**
 * Represents a non-generic collection of objects that can be individually accessed by index.
 */
interface IList extends ICollection, ArrayAccess
{

    /**
     * Adds an item to the IList.
     * @param mixed $item The object to add to the IList.
     * @return ArrayList
     */
    public function add($item);

    /**
     * Adds the elements of the specified collection to the end of the IList.
     * @param ICollection|array $items The collection whose elements should be added to the end of the IList.
     * @return ArrayList
     */
    public function addAll($items);

    /**
     * Inserts an item to the IList at the specified index.
     * @param int $index The zero-based index at which value should be inserted.
     * @param mixed $item The object to insert into the IList.
     * @return ArrayList
     */
    public function insert($index, $item);

    /**
     * Determines the index of a specific item in the IList.
     * @param mixed $item The object to locate in the IList.
     */
    public function indexOf($item);
}
