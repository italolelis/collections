<?php

namespace Collections;

use Rx\Observable\ArrayObservable;

interface Iterable extends \IteratorAggregate
{
    /**
     * @return array
     */
    public function toArray();

    /**
     * @return array
     */
    public function toValuesArray();

    /**
     * @return VectorInterface
     */
    public function toVector();

    /**
     * @return ConstVectorInterface
     */
    public function toImmVector();

    /**
     * @return
     */
    public function toSet();

    /**
     * Returns an immutable set (`ImmSet`) converted from the current `Iterable`.
     *
     * Any keys in the current `Iterable` are discarded.
     *
     * @return ConstSetInterface - an `ImmSet` converted from the current `Iterable`.
     */
    public function toImmSet();

    /**
     * @return ArrayObservable
     */
    public function toObservable();

    /**
     * Returns a lazy, access elements only when needed view of the current
     * `Iterable`.
     *
     * Normally, memory is allocated for all of the elements of the `Iterable`.
     * With a lazy view, memory is allocated for an element only when needed or
     * used in a calculation like in `map()` or `filter()`.
     *
     * @return Iterable - an `Iterable` representing the lazy view into the current
     *           `Iterable`.
     */
    public function lazy();

    /**
     * Returns an `Iterable` containing the current `Iterable`'s values.
     *
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
     * Merge the elements of this vector into another
     * @param \Traversable $collection
     * @return Iterable
     */
    public function concat(\Traversable $collection);

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

    public function groupBy($callback);

    public function indexBy($callback);

    public function exists(callable $fn);

    public function concatAll();
}
