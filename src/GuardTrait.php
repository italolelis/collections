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
     * @param int $i
     * @return mixed
     * @throws IndexException
     */
    protected function existsGuard($i)
    {
        if (!$this->offsetExists($i)) {
            throw new IndexException();
        }
        return $i;
    }

    protected function intGuard($i)
    {
        if (filter_var($i, FILTER_VALIDATE_INT) === false) {
            throw new TypeException();
        }
        return (int)$i;
    }

}
