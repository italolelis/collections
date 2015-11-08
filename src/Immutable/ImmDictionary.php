<?php

namespace Collections\Immutable;

use Collections\ConstMapInterface;
use Iterable;
use Traversable;

class ImmDictionary implements ConstMapInterface
{

    /**
     * Verifies whether a collection is empty
     * @return bool Returns TRUE if the collection is empty; FASLE otherswise.
     */
    public function isEmpty()
    {
        // TODO: Implement isEmpty() method.
    }

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
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        // TODO: Implement getIterator() method.
    }

    public function toArray()
    {
        // TODO: Implement toArray() method.
    }

    public function toValuesArray()
    {
        // TODO: Implement toValuesArray() method.
    }

    public function toVector()
    {
        // TODO: Implement toVector() method.
    }

    public function toImmVector()
    {
        // TODO: Implement toImmVector() method.
    }

    public function toSet()
    {
        // TODO: Implement toSet() method.
    }

    public function toImmSet()
    {
        // TODO: Implement toImmSet() method.
    }

    public function lazy()
    {
        // TODO: Implement lazy() method.
    }

    /**
     * Gets an VectorInterface object containing the values in the VectorInterface object.
     * @return Iterable
     */
    public function values()
    {
        // TODO: Implement values() method.
    }

    /**
     * Returns another collection after modifying each of the values in this one using
     * the provided callable.
     *
     * Each time the callback is executed it will receive the value of the element
     * in the current iteration, the key of the element and this collection as
     * arguments, in that order.
     *
     * @param callable $callable the method that will receive each of the elements and
     * returns the new value for the key that is being iterated
     * @return Iterable
     */
    public function map(callable $callable)
    {
        // TODO: Implement map() method.
    }

    /**
     * Returns all the elements of this collection that satisfy the predicate p.
     * The order of the elements is preserved.
     *
     * @param callable $callable The callable used for filtering.
     * @return Iterable A iterable with the results of the filter operation.
     */
    public function filter(callable $callable)
    {
        // TODO: Implement filter() method.
    }

    public function take($size = 1, $from = 0)
    {
        // TODO: Implement take() method.
    }

    public function skip($n)
    {
        // TODO: Implement skip() method.
    }

    /**
     * Slice the iteravle in place. This function provides the functional equivalent of array_splice(), but for vectors.
     * @param int $start
     * @param int $length
     * @return Iterable
     */
    public function slice($start, $length = null)
    {
        // TODO: Implement slice() method.
    }

    /**
     * Merge the elements of this vector into another
     * @param Traversable $collection
     * @return Iterable
     */
    public function concat(Traversable $collection)
    {
        // TODO: Implement concat() method.
    }

    public function first()
    {
        // TODO: Implement first() method.
    }

    public function last()
    {
        // TODO: Implement last() method.
    }

    /**
     * Returns an array whose values are the keys from the ICollection.
     * @return array
     */
    public function toKeysArray()
    {
        // TODO: Implement toKeysArray() method.
    }

    public function toMap()
    {
        // TODO: Implement toMap() method.
    }

    public function toImmMap()
    {
        // TODO: Implement toImmMap() method.
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