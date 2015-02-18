<?php

namespace Collections\Iterator;

class SortedSetIterator extends IteratorCollectionAdapter implements SetIterator
{

    private $size = 0;

    public function __construct(BinaryTreeIterator $iterator, $size)
    {
        parent::__construct(new ValueIterator($iterator));
        $this->size = $size;
        $this->rewind();
    }


    /**
     * @link http://php.net/manual/en/countable.count.php
     * @return int
     */
    public function count()
    {
        return $this->size;
    }

}
