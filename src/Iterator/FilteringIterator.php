<?php

namespace Collections\Iterator;

class FilteringIterator extends IteratorCollectionAdapter
{

    /**
     * @var callable
     */
    private $filter;
    private $current;
    private $key;

    /**
     * @var bool
     */
    private $valid;


    public function __construct(\Iterator $iterator, callable $filter)
    {
        parent::__construct($iterator);
        $this->filter = $filter;
    }


    /**
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed
     */
    public function current()
    {
        return $this->current;
    }


    /**
     * @link http://php.net/manual/en/iterator.next.php
     * @return void
     */
    public function next()
    {
        $this->valid = false;
        while ($this->inner->valid()) {
            $key = $this->inner->key();
            $current = $this->inner->current();
            if (call_user_func($this->filter, $current, $key)) {
                $this->key = $key;
                $this->current = $current;
                $this->valid = true;
                $this->inner->next();
                break;
            }
            $this->inner->next();
        }
    }


    /**
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed
     */
    public function key()
    {
        return $this->key;
    }


    /**
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean
     */
    public function valid()
    {
        return $this->valid;
    }


    /**
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void
     */
    public function rewind()
    {
        $this->inner->rewind();
        $this->key = null;
        $this->next();
    }

}
