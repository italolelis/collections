<?php

namespace Collections\Iterator;

class LimitingIterator extends IteratorCollectionAdapter
{

    /**
     * @var int
     */
    private $n;

    private $used = 0;


    /**
     * @param \Iterator $iterator
     * @param int $n
     */
    public function __construct(\Iterator $iterator, $n)
    {
        parent::__construct($iterator);
        $this->n = $n;
    }


    /**
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void
     */
    public function rewind()
    {
        parent::rewind();
        $this->used = 0;
    }


    /**
     * @link http://php.net/manual/en/iterator.next.php
     * @return void
     */
    public function next()
    {
        $this->used++;
        if ($this->used < $this->n) {
            $this->inner->next();
        }
    }


    /**
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean
     */
    public function valid()
    {
        return $this->used < $this->n && parent::valid();
    }
}
