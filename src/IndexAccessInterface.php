<?php

namespace Collections;

use ArrayAccess;

interface IndexAccessInterface extends ArrayAccess
{
    /**
     * Store a value into the collection with the specified key, overwriting a previous value if already present.
     *
     * @param int $key
     * @param mixed $value
     * @return IndexAccessInterface
     */
    public function set($key, $value);
}
