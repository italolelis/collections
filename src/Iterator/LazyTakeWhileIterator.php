<?php

namespace Collections\Iterator;

class LazyTakeWhileIterator implements \Iterator
{
    /**
     * @var \Iterator
     */
    private $it;

    /**
     * @var callable
     */
    private $fn;

    public function __construct($it, $fn)
    {
        $this->it = $it;
        $this->fn = $fn;
        while ($it->valid() && $fn($it->current())) {
            $it->next();
        }
    }

    public function __clone()
    {
        $this->it = clone $this->it;
    }

    public function rewind()
    {
        $this->it->rewind();
    }

    public function valid()
    {
        $it = $this->it;
        $fn = $this->fn;

        return ($it->valid() && $fn($it->current()));
    }

    public function next()
    {
        $this->it->next();
    }

    public function key()
    {
        return $this->it->key();
    }

    public function current()
    {
        return $this->it->current();
    }
}
