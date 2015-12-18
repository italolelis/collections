<?php

namespace Collections;

/**
 * The interface for mutable `Set`s to enable removal of its values.
 */
interface SetAccessInterface extends ConstSetAccessInterface
{
    /**
     * Removes the provided value from the current `Set`.
     *
     * If the value is not in the current `Set`, the `Set` is unchanged.
     *
     * It returns a shallow copy of the current `Set`, meaning changes
     * made to the current `Set` will be reflected in the returned
     * `Set`.
     *
     * @param $index - The value to remove.
     *
     * @return $this - A shallow copy of the current `Set`.
     */
    public function remove($index);
}
