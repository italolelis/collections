<?php

namespace Collections;

interface IndexAccessInterface
{
    /**
     * Store a value into the collection with the specified key, overwriting a previous value if already present.
     *
     * @param int $key
     * @param mixed $value
     * @return IndexAccessInterface
     */
    public function set($key, $value);

    public function setAll($traversable);

    /**
     * Removes a value from the collection based on it's key.
     * @param mixed $key
     * @return IndexAccessInterface
     */
    public function removeKey($key);
}
