<?php

namespace Collections\Iterator;

use Collections\KeyedIterator;

class LazySkipKeyedIterator implements KeyedIterator
{
    /**
     * @var KeyedIterator
     */
    private $it;

    /**
     * @var int
     */
    private $n;

    public function __construct($it, $n)
    {
        $this->it = $it;
        $this->n = $n;
        while ($n > 0 && $it->valid()) {
            $it->next();
            --$n;
        }
    }

    public function __clone()
    {
        $this->it = clone $this->it;
    }

    public function rewind()
    {
        $it = $this->it;
        $n = $this->n;
        $it->rewind();
        while ($n > 0 && $it->valid()) {
            $it->next();
            --$n;
        }
    }

    public function valid()
    {
        return $this->it->valid();
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
