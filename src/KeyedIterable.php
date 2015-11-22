<?php

namespace Collections;

interface KeyedIterable extends KeyedTraversable, Iterable
{
    /**
     * Returns an array whose values are the keys from the ICollection.
     * @return array
     */
    public function toKeysArray();

    /**
     * @return MapInterface
     */
    public function toMap();

    /**
     * @return ConstMapInterface
     */
    public function toImmMap();
}
