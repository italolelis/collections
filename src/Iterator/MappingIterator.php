<?php

namespace Collections\Iterator;

class MappingIterator extends IteratorCollectionAdapter
{

    /**
     * @var callable
     */
    private $mapper;


    public function __construct(\Iterator $iterator, callable $map)
    {
        parent::__construct($iterator);
        $this->mapper = $map;
    }


    /**
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed
     */
    public function current()
    {
        return call_user_func(
            $this->mapper,
            $this->inner->current(),
            $this->inner->key()
        );
    }
}
