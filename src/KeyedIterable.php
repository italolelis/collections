<?php

namespace Collections;

/**
 * Interface KeyedIterable
 * @package Collections
 */
interface KeyedIterable extends KeyedTraversable, Iterable
{
    /**
     * Returns an array with the keys from the current `KeyedIterable`.
     * @return array - an array containing the values from the current `KeyedIterable`.
     */
    public function toKeysArray();

    /**
     * Returns a `Map` based on the keys and values of the current `KeyedIterable`.
     * @return MapInterface - a `Map` that has the keys and associated values of the current `KeyedIterable`.
     */
    public function toMap();

    /**
     * Returns an `Iterable` containing the current `KeyedIterable`'s keys.
     * Any values are discarded.
     * @return VectorInterface - `Iterable` with the keys of the current `KeyedIterable`.
     */
    public function keys();

    /**
     * Returns an `KeyedIterable` containing the values after an operation has been
     * applied to each value in the current `KeyedIterable`.
     *
     * Every value in the current `KeyedIterable` is affected by a call to `mapWithKey()`,
     * unlike `filterWithKey()` where only values that meet a certain criteria are
     * affected.
     *
     * @param $fn - The callback containing the operation to apply to the
     *              `KeyedIterable` values.
     *
     * @return KeyedIterable - an `KeyedIterable` containing the values after a user-specified
     *           operation is applied.
     */
    public function mapWithKey($callback);

    /**
     * Returns an `KeyedIterable` containing the values of the current `KeyedIterable` that
     * meet a supplied condition.
     *
     * Only values that meet a certain criteria are affected by a call to
     * `filterWithKey()`, while all values are affected by a call to `mapWithKey()`.
     *
     * @param $fn - The callback containing the condition to apply to the
     *              `KeyedIterable` values.
     *
     * @return KeyedIterable - an `KeyedIterable` containing the values after a user-specified
     *           condition is applied.
     */
    public function filterWithKey($callback);

    /**
     * @return ConstMapInterface
     */
    public function toImmMap();
}
