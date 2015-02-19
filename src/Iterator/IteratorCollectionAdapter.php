<?php

namespace Collections\Iterator;

class IteratorCollectionAdapter implements \Iterator, \OuterIterator
{

    use IteratorCollectionTrait;

    /**
     * @var \Iterator
     */
    protected $inner;


    public function __construct(\Iterator $Iterator)
    {
        $this->inner = $Iterator;
    }


    public function getInnerIterator()
    {
        return $this->inner;
    }


    /**
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed
     */
    public function current()
    {
        return $this->inner->current();
    }


    /**
     * @link http://php.net/manual/en/iterator.next.php
     * @return void
     */
    public function next()
    {
        $this->inner->next();
    }


    /**
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed
     */
    public function key()
    {
        return $this->inner->key();
    }


    /**
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean
     */
    public function valid()
    {
        return $this->inner->valid();
    }


    /**
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void
     */
    public function rewind()
    {
        $this->inner->rewind();
    }

}
