<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

use Closure;
use Countable;
use IteratorAggregate;
use Serializable;

/**
 * Provides functionality to evaluate queries against a specific data source wherein the type of the data is not
 * specified.
 */
interface CollectionInterface extends Countable, Serializable, IteratorAggregate
{

    /**
     * Clear all of the elements in the collection
     * @return AbstractCollectionArray
     */
    public function clear();

    /**
     * Verifies whether a colletion is empty
     * @return boolean
     */
    public function isEmpty();

    /**
     * Gets an CollectionInterface object containing the values in the IDictionary object.
     */
    public function values();

    /**
     * Merge the elements of this Collection into another
     * @param CollectionConvertableInterface $collection
     * @return CollectionInterface
     */
    public function concat(CollectionConvertableInterface $collection);

    /**
     * Adds all the key/value Pairs from the Traversable to the IList.
     * @param \Traversable|array $items The collection whose elements should be added to the end of the IList.
     * @return VectorInterface
     */
    public function addAll($items);
}
