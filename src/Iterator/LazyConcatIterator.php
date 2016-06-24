<?php

namespace Collections\Iterator;

class LazyConcatIterator implements \Iterator
{
    /**
     * @var \Iterator
     */
    private $it1;

    /**
     * @var \Iterator
     */
    private $it2;

    /**
     * @var \Iterator
     */
    private $currentIt;

    /**
     * @var int
     */
    private $state;

    public function __construct($it1, $it2)
    {
        $this->it1 = $it1;
        $this->it2 = $it2;
        $this->currentIt = $it1;
        $this->state = 1;

        if (!$this->currentIt->valid()) {
            $this->currentIt = $this->it2;
            $this->state = 2;
        }
    }

    public function __clone()
    {
        $this->it1 = clone $this->it1;
        $this->it2 = clone $this->it2;

        $this->currentIt = ($this->state === 1) ? $this->it1 : $this->it2;
    }

    public function rewind()
    {
        $this->it1->rewind();
        $this->it2->rewind();
        $this->currentIt = $this->it1;
        $this->state = 1;

        if (!$this->currentIt->valid()) {
            $this->currentIt = $this->it2;
            $this->state = 2;
        }
    }

    public function valid()
    {
        return $this->currentIt->valid();
    }

    public function next()
    {
        $this->currentIt->next();

        if ($this->state === 1 && !$this->currentIt->valid()) {
            $this->currentIt = $this->it2;
            $this->state = 2;
        }
    }

    public function key()
    {
        return $this->currentIt->key();
    }

    public function current()
    {
        return $this->currentIt->current();
    }
}
