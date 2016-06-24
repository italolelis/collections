<?php

namespace Collections;

interface IndexAccessInterface
{
    /**
     * Stores a value into the current collection with the specified key,
     * overwriting the previous value associated with the key.
     *
     * If the key is not present, an exception is thrown.
     * If you want to add a value even if a key is not present, use add().
     *
     * `$coll->set($key,$value)` is semantically equivalent to `$coll[$k] = $v`
     * (except that set() returns the current collection).
     *
     * @param string|int $key The key to which we will set the value.
     * @param mixed $value The value to set.
     * @return IndexAccessInterface A shallow copy of the current collection with the updated the value set.
     */
    public function set($key, $value);

    /**
     * For every element in the provided Traversable, stores a value into the current collection associated
     * with each key, overwriting the previous value associated with the key.
     *
     * If a key is not present the current collection that is present in the Traversable,
     * an exception is thrown. If you want to add a value even if a key is not present, use `addAll()`.
     *
     * @param array|\Traversable $traversable - The Traversable with the new values to set. If null is provided, no changes are made.
     * @return IndexAccessInterface A shallow copy of the current collection with the updated the values set.
     */
    public function setAll($traversable);

    /**
     * Removes the specified key (and associated value) from the current collection.
     * If the key is not in the current collection, the current collection is unchanged.
     * It returns a shallow copy of the current collection, meaning changes made to the current
     * collection will be reflected in the returned collection.
     *
     * @param mixed $key
     * @return IndexAccessInterface
     */
    public function removeKey($key);
}
