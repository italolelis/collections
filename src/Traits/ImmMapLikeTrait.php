<?php

namespace Collections\Traits;

use Collections\Exception\InvalidOperationException;

trait ImmMapLikeTrait
{
    use ConstMapLikeTrait, CommonImmMutableContainerTrait;

    /**
     * identical to at, implemented for ArrayAccess
     */
    public function offsetGet($offset)
    {
        return $this->at($offset);
    }

    public function offsetSet($offset, $value)
    {
        throw InvalidOperationException::unsupportedSet($this);
    }

    public function offsetUnset($offset)
    {
        throw InvalidOperationException::unsupportedUnset($this);
    }
}
