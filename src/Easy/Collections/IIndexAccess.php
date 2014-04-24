<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

use ArrayAccess;

/**
 * Allows for access key-based collections with methods such as indexOf().
 */
interface IIndexAccess extends ArrayAccess
{

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
