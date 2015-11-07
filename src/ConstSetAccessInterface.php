<?php

namespace Collections;

interface ConstSetAccessInterface
{
    /**
     * Determines whether the collection object contains an element with the specified key.
     * @param mixed $item The key to locate in the collection object.
     * @return bool
     */
    public function contains($item);
}
