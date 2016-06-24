<?php

namespace Collections\Iterator;

class LazyMapWithKeyIterator extends LazyMapIterator
{
    public function current()
    {
        $fn = $this->fn;

        return $fn($this->it->key(), $this->it->current());
    }
}
