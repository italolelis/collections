<?php

namespace Collections;

use Collections\Immutable\ImmVector;

interface Enumerable extends \IteratorAggregate
{
    /**
     * Returns an array converted from the current Enumerable.
     * @return array - an array converted from the current Enumerable.
     */
    public function toArray();

    /**
     * Returns an array with the values from the current Enumerable.
     * The keys in the current Enumerable are discarded and replaced with integer indices, starting with 0.
     * @return array - an array containing the values from the current Enumerable.
     */
    public function toValuesArray();

    /**
     * Returns a Vector converted from the current Enumerable.
     * Any keys in the current Enumerable are discarded and replaced with integer indices, starting with 0.
     * @return VectorInterface - a Vector converted from the current Enumerable.
     */
    public function toVector();

    /**
     * Returns an immutable vector (`ImmVector`) converted from the current `Enumerable`.
     * Any keys in the current `Enumerable` are discarded and replaced with integer indices, starting with 0.
     * @return ImmVector - an `ImmVector` converted from the current `Enumerable`.
     */
    public function toImmVector();

    /**
     * Returns a `Set` converted from the current `Enumerable`.
     * Any keys in the current `Enumerable` are discarded.
     * @return SetInterface - a `Set` converted from the current `Enumerable`.
     */
    public function toSet();

    /**
     * Returns an immutable set (`ImmSet`) converted from the current `Enumerable`.
     * Any keys in the current `Enumerable` are discarded.
     *
     * @return ConstSetInterface - an `ImmSet` converted from the current `Enumerable`.
     */
    public function toImmSet();

    /**
     * Returns an `Enumerable` containing the current `Enumerable`'s values.
     * Any keys are discarded.
     *
     * @return Enumerable - An `Enumerable` with the values of the current `Enumerable`.
     */
    public function values();

    /**
     * Executes the passed callable for each of the elements in this collection
     * and passes both the value and key for them on each step.
     * Returns the same collection for chaining.
     *
     * @param callable $fn - A callable function that will receive each of the elements
     * in this collection
     * @return Enumerable - The same `Enumerable` instance.
     */
    public function each(callable $fn);

    /**
     * Returns an `Enumerable` containing the values after an operation has been
     * applied to each value in the current `Enumerable`.
     *
     * Every value in the current `Enumerable` is affected by a call to `map()`,
     * unlike `filter()` where only values that meet a certain criteria are
     * affected.
     *
     * @param $fn - The callback containing the operation to apply to the
     *              `Enumerable` values.
     *
     * @return Enumerable - an `Enumerable` containing the values after a user-specified
     *           operation is applied.
     */
    public function map(callable $fn);

    /**
     * Returns an `Enumerable` containing the values of the current `Enumerable` that
     * meet a supplied condition.
     *
     * Only values that meet a certain criteria are affected by a call to
     * `filter()`, while all values are affected by a call to `map()`.
     *
     * @param $fn - The callback containing the condition to apply to the
     *              `Itearble` values.
     *
     * @return Enumerable - an `Enumerable` containing the values after a user-specified
     *           condition is applied.
     */
    public function filter(callable $fn);

    /**
     * Returns an `Enumerable` containing the first `n` values of the current
     * `Enumerable`.
     *
     * The returned `Enumerable` will always be a proper subset of the current
     * `Enumerable`.
     *
     * `$n` is 1-based. So the first element is 1, the second 2, etc.
     *
     * @param $size - The last element that will be included in the returned
     *             `Enumerable`.
     *
     * @return Enumerable - An `Enumerable that is a proper subset of the current `Enumerable`
     *           up to `n` elements.
     */
    public function take($size = 1);

    /**
     * Returns an `Enumerable` containing the values after the `n`-th element of the
     * current `Enumerable`.
     *
     * The returned `Enumerable` will always be a proper subset of the current
     * `Enumerable`.
     *
     * `$n` is 1-based. So the first element is 1, the second 2, etc.
     *
     * @param $n - The last element to be skipped; the `$n+1` element will be
     *             the first one in the returned `Enumerable`.
     *
     * @return Enumerable - An `Enumerable` that is a proper subset of the current `Enumerable`
     *           containing values after the specified `n`-th element.
     */
    public function skip($n);

    /**
     * Returns a subset of the current `Enumerable` starting from a given key up
     * to, but not including, the element at the provided length from the
     * starting key.
     *
     * `$start` is 0-based. `$len` is 1-based. So `slice(0, 2)` would return the
     * elements at key 0 and 1.
     *
     * The returned `Enumerable` will always be a proper subset of the current
     * `Enumerable`.
     *
     * @param $start - The starting key of the current `Enumerable` to begin the
     *                 returned `Enumerable`.
     * @param $length - The length of the returned `Enumerable`.
     *
     * @return Enumerable - An `Enumerable` that is a proper subset of the current `Enumerable`
     *           starting at `$start` up to but not including the element
     *           `$start + $len`.
     */
    public function slice($start, $length);

    /**
     * Returns an `Enumerable` that is the concatenation of the values of the current `Enumerable`
     * and the values of the provided `Traversable`.
     *
     * The values of the provided `Traversable` is concatenated to the end of the current `Enumerable`
     * to produce the returned `Enumerable`.
     *
     * @param \Traversable|array $traversable - The `Traversable` to concatenate to the current `Enumerable`.
     * @return Enumerable - The concatenated `Enumerable`.
     */
    public function concat($traversable);

    /**
     * Returns the first value in the current `Enumerable`.
     *
     * @return mixed - The first value in the current `Enumerable`, or `null` if the
     *           current `Enumerable` is empty.
     */
    public function first();

    /**
     * Returns the last value in the current `Enumerable`.
     *
     * @return mixed - The last value in the current `Enumerable`, or `null` if the
     *           current `Enumerable` is empty.
     */
    public function last();

    /**
     * Returns a `ConstVector` where each element is a `Pair` that combines the
     * element of the current `ConstVector` and the provided `Traversable`.
     *
     * If the number of elements of the `Enumerable` are not equal to the
     * number of elements in the `Traversable`, then only the combined elements
     * up to and including the final element of the one with the least number of
     * elements is included.
     *
     * @param $traversable - The `Traversable` to use to combine with the
     *                       elements of this `Enumerable`.
     *
     * @return - The `Enumerable` that combines the values of the current
     *           `Enumerable` with the provided `Traversable`.
     */
    public function zip($traversable);

    /**
     * Groups the collection based on a given criteria
     * @param $callback
     * @return Enumerable
     */
    public function groupBy($callback);

    /**
     * Indexes the collection based on a given criteria
     * @param $callback
     * @return Enumerable
     */
    public function indexBy($callback);

    /**
     * Verifies if an element exists in the collection for a given criteria
     * @param callable $fn
     * @return Enumerable
     */
    public function exists(callable $fn);

    /**
     * Flatten the collection into one dimension
     * @return Enumerable
     */
    public function concatAll();
}
