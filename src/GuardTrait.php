<?php

namespace Collections;

use Collections\Exception\EmptyException;
use Collections\Exception\IndexException;
use Collections\Exception\TypeException;

trait GuardTrait
{
    abstract function isEmpty();

    abstract function count();

    protected function emptyGuard($method)
    {
        if ($this->isEmpty()) {
            throw new EmptyException(
                "{$method} cannot be called when the structure is empty"
            );
        }
    }

    protected function validateKeyBounds($k)
    {
        if (!$this->isBoundedKey($k)) {
            throw new \OutOfBoundsException("Integer key $k is out of bounds");
        }
    }

    /**
     * @param int $element
     * @return mixed
     */
    protected function isBoundedKey($element)
    {
        return $element >= 0 && $element < $this->count();
    }

    protected function validateKeyType($element)
    {
        if (filter_var($element, FILTER_VALIDATE_INT) === false) {
            throw new TypeException('Only integer keys may be used with ' . (get_class($this)));
        }
    }
}
