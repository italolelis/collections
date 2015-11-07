<?php

namespace Collections;

interface OutputCollectionInterface
{
    /**
     * Adds all the key/value Pairs from the Traversable to the collection.
     * @param \Traversable|array $items The collection whose elements should be added to the end of the collection.
     * @return OutputCollectionInterface
     */
    public function addAll($items);
}
