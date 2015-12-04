<?php

namespace Collections\Traits;

use Collections\Exception\EmptyException;
use Collections\Exception\TypeException;

trait GuardTrait
{
    /**
     * @return bool
     */
    abstract public function isEmpty();

    /**
     * @return int
     */
    abstract public function count();

    /**
     * @param string $method
     *
     * @throws EmptyException
     */
    protected function emptyGuard($method)
    {
        if ($this->isEmpty()) {
            throw new EmptyException(
                "{$method} cannot be called when the structure is empty"
            );
        }
    }

    /**
     * @param $key
     */
    protected function validateKeyBounds($key)
    {
        if (!$this->isBoundedKey($key)) {
            throw new \OutOfBoundsException("Integer key $key is out of bounds");
        }
    }

    /**
     * @param int $element
     *
     * @return bool
     */
    protected function isBoundedKey($element)
    {
        return ($element >= 0 && $element < $this->count());
    }

    /**
     * @param int $element
     *
     * @throws TypeException
     */
    protected function validateKeyType($element)
    {
        if (filter_var($element, FILTER_VALIDATE_INT) === false) {
            throw new TypeException('Only integer keys may be used with '.(get_class($this)));
        }
    }
}
