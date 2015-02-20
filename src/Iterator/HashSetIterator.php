<?php

namespace Collections\Iterator;

class HashSetIterator extends IteratorCollectionAdapter implements SetIteratorInterface
{

    private $size = 0;


    public function __construct(array $set)
    {
        parent::__construct(new ValueIterator(new \ArrayIterator($set)));
        $this->size = count($set);
        $this->rewind();
    }


    public function count()
    {
        return $this->size;
    }
}
