<?php

namespace Collections;

use Collections\Exception\EmptyException;
use Collections\Exception\IndexException;
use Collections\Exception\TypeException;

trait GuardTrait
{

    abstract function isEmpty();

    protected function emptyGuard($method)
    {
        if ($this->isEmpty()) {
            throw new EmptyException(
                "{$method} cannot be called when the structure is empty"
            );
        }
    }

    /**
     * @param int $element
     * @return mixed
     * @throws IndexException
     */
    protected function existsGuard($element)
    {
        if (!$this->offsetExists($element)) {
            throw new IndexException();
        }
        return $element;
    }

    protected function intGuard($element)
    {
        if (filter_var($element, FILTER_VALIDATE_INT) === false) {
            throw new TypeException();
        }
        return (int)$element;
    }
}
