<?php

namespace Collections\Iterator;

use Collections\KeyedIterator;

class LazySliceKeyedIterator implements KeyedIterator
{
    /**
     * @var KeyedIterator
     */
    private $it;

    /**
     * @var int
     */
    private $start;

    /**
     * @var int
     */
    private $len;

    /**
     * @var int
     */
    private $currentLen;

    public function __construct($it, $start, $len)
    {
        $this->it = $it;
        $this->start = $start;
        $this->len = $len;
        $this->currentLen = $len;
        while ($start !== 0 && $it->valid()) {
            $it->next();
            --$start;
        }
    }

    public function __clone()
    {
        $this->it = clone $this->it;
    }

    public function rewind()
    {
        $it = $this->it;
        $start = $this->start;
        $len = $this->len;
        $it->rewind();
        $this->currentLen = $len;
        while ($start !== 0 && $it->valid()) {
            $it->next();
            --$start;
        }
    }

    public function valid()
    {
        return $this->it->valid() && $this->currentLen !== 0;
    }

    public function next()
    {
        $this->it->next();
        if ($this->currentLen !== 0) {
            --$this->currentLen;
        }
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
