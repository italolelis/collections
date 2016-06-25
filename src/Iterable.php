<?php

namespace Collections;

use Collections\Immutable\ImmVector;

interface Iterable extends \IteratorAggregate
{
    /**
     * Returns an array converted from the current Iterable.
     * @return array - an array converted from the current Iterable.
     */
    public function toArray();

    /**
     * Returns an array with the values from the current Iterable.
     * The keys in the current Iterable are discarded and replaced with integer indices, starting with 0.
     * @return array - an array containing the values from the current Iterable.
     */
    public function toValuesArray();

    /**
     * Returns a Vector converted from the current Iterable.
     * Any keys in the current Iterable are discarded and replaced with integer indices, starting with 0.
     * @return VectorInterface - a Vector converted from the current Iterable.
     */
    public function toVector();

    /**
     * Returns an immutable vector (`ImmVector`) converted from the current `Iterable`.
     * Any keys in the current `Iterable` are discarded and replaced with integer indices, starting with 0.
     * @return ImmVector - an `ImmVector` converted from the current `Iterable`.
     */
    public function toImmVector();

    /**
     * Returns a `Set` converted from the current `Iterable`.
     * Any keys in the current `Iterable` are discarded.
     * @return SetInterface - a `Set` converted from the current `Iterable`.
     */
    public function toSet();

    /**
     * Returns an immutable set (`ImmSet`) converted from the current `Iterable`.
     * Any keys in the current `Iterable` are discarded.
     *
     * @return ConstSetInterface - an `ImmSet` converted from the current `Iterable`.
     */
    public function toImmSet();

    /**
     * Returns an `Iterable` containing the current `Iterable`'s values.
     * Any keys are discarded.
     *
     * @return Iterable - An `Iterable` with the values of the current `Iterable`.
     */
    public function values();

    /**
     * Executes the passed callable for each of the elements in this collection
     * and passes both the value and key for them on each step.
     * Returns the same collection for chaining.
     *
     * @param callable $fn - A callable function that will receive each of the elements
     * in this collection
     * @return Iterable - The same `Iterable` instance.
     */
    public function each(callable $fn);

    /**
     * Returns an `Iterable` containing the values after an operation has been
     * applied to each value in the current `Iterable`.
     *
     * Every value in the current `Iterable` is affected by a call to `map()`,
     * unlike `filter()` where only values that meet a certain criteria are
     * affected.
     *
     * @param $fn - The callback containing the operation to apply to the
     *              `Iterable` values.
     *
     * @return Iterable - an `Iterable` containing the values after a user-specified
     *           operation is applied.
     */
    public function map(callable $fn);

    /**
     * Returns an `Iterable` containing the values of the current `Iterable` that
     * meet a supplied condition.
     *
     * Only values that meet a certain criteria are affected by a call to
     * `filter()`, while all values are affected by a call to `map()`.
     *
     * @param $fn - The callback containing the condition to apply to the
     *              `Itearble` values.
     *
     * @return Iterable - an `Iterable` containing the values after a user-specified
     *           condition is applied.
     */
    public function filter(callable $fn);

    /**
     * Returns an `Iterable` containing the first `n` values of the current
     * `Iterable`.
     *
     * The returned `Iterable` will always be a proper subset of the current
     * `Iterable`.
     *
     * `$n` is 1-based. So the first element is 1, the second 2, etc.
     *
     * @param $size - The last element that will be included in the returned
     *             `Iterable`.
     *
     * @return Iterable - An `Iterable that is a proper subset of the current `Iterable`
     *           up to `n` elements.
     */
    public function take($size = 1);

    /**
     * Returns an `Iterable` containing the values after the `n`-th element of the
     * current `Iterable`.
     *
     * The returned `Iterable` will always be a proper subset of the current
     * `Iterable`.
     *
     * `$n` is 1-based. So the first element is 1, the second 2, etc.
     *
     * @param $n - The last element to be skipped; the `$n+1` element will be
     *             the first one in the returned `Iterable`.
     *
     * @return Iterable - An `Iterable` that is a proper subset of the current `Iterable`
     *           containing values after the specified `n`-th element.
     */
    public function skip($n);

    /**
     * Returns a subset of the current `Iterable` starting from a given key up
     * to, but not including, the element at the provided length from the
     * starting key.
     *
     * `$start` is 0-based. `$len` is 1-based. So `slice(0, 2)` would return the
     * elements at key 0 and 1.
     *
     * The returned `Iterable` will always be a proper subset of the current
     * `Iterable`.
     *
     * @param $start - The starting key of the current `Iterable` to begin the
     *                 returned `Iterable`.
     * @param $length - The length of the returned `Iterable`.
     *
     * @return Iterable - An `Iterable` that is a proper subset of the current `Iterable`
     *           starting at `$start` up to but not including the element
     *           `$start + $len`.
     */
    public function slice($start, $length);

    /**
     * Returns an `Iterable` that is the concatenation of the values of the current `Iterable`
     * and the values of the provided `Traversable`.
     *
     * The values of the provided `Traversable` is concatenated to the end of the current `Iterable`
     * to produce the returned `Iterable`.
     *
     * @param \Traversable|array $traversable - The `Traversable` to concatenate to the current `Iterable`.
     * @return Iterable - The concatenated `Iterable`.
     */
    public function concat($traversable);

    /**
     * Returns the first value in the current `Iterable`.
     *
     * @return mixed - The first value in the current `Iterable`, or `null` if the
     *           current `Iterable` is empty.
     */
    public function first();

    /**
     * Returns the last value in the current `Iterable`.
     *
     * @return mixed - The last value in the current `Iterable`, or `null` if the
     *           current `Iterable` is empty.
     */
    public function last();

    /**
     * Returns a `ConstVector` where each element is a `Pair` that combines the
     * element of the current `ConstVector` and the provided `Traversable`.
     *
     * If the number of elements of the `Iterable` are not equal to the
     * number of elements in the `Traversable`, then only the combined elements
     * up to and including the final element of the one with the least number of
     * elements is included.
     *
     * @param $traversable - The `Traversable` to use to combine with the
     *                       elements of this `Iterable`.
     *
     * @return - The `Iterable` that combines the values of the current
     *           `Iterable` with the provided `Traversable`.
     */
    public function zip($traversable);

    /**
     * Groups the collection based on a given criteria
     * @param $callback
     * @return Iterable
     */
    public function groupBy($callback);

    /**
     * Indexes the collection based on a given criteria
     * @param $callback
     * @return Iterable
     */
    public function indexBy($callback);

    /**
     * Verifies if an element exists in the collection for a given criteria
     * @param callable $fn
     * @return Iterable
     */
    public function exists(callable $fn);

    /**
     * Flatten the collection into one dimension
     * @return Iterable
     */
    public function concatAll();
}
