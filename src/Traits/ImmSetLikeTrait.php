<?php

namespace Collections\Traits;

use Collections\Exception\InvalidOperationException;

trait ImmSetLikeTrait
{
    use ConstSetLikeTrait, CommonImmMutableContainerTrait;

    public function offsetSet($offset, $value)
    {
        throw InvalidOperationException::unsupportedSet($this);
    }

    public function offsetUnset($offset)
    {
        throw InvalidOperationException::unsupportedUnset($this);
    }
}
