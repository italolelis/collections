<?php

namespace Collections\Traits;

use Collections\Exception\InvalidOperationException;

trait ImmVectorLikeTrait
{
    use ConstVectorLikeTrait, CommonImmMutableContainerTrait;

    /**
     * identical to at, implemented for ArrayAccess
     */
    public function offsetGet($offset)
    {
        $this->validateKeyType($offset);
        $this->validateKeyBounds($offset);

        return $this->container[$offset];
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
