<?php

namespace Collections\Iterator;

use Collections\Exception\IndexException;
use Collections\VectorConvertableInterface;

class VectorIterator extends IteratorCollectionAdapter implements CountableSeekableIteratorInterface, \Iterator
{

    public function __construct(VectorConvertableInterface $vector)
    {
        parent::__construct(new \ArrayIterator($vector->toArray()));
        $this->rewind();
    }


    /**
     * @link http://php.net/manual/en/countable.count.php
     * @return int
     */
    public function count()
    {
        return $this->getInnerIterator()->count();
    }


    /**
     * @param int $index
     * @link http://php.net/manual/en/seekableiterator.seek.php
     * @return void
     * @throws IndexException if it cannot seek to the position
     */
    public function seek($index)
    {
        if ($index < 0 || $index >= $this->getInnerIterator()->count()) {
            throw new IndexException();
        }
        $this->getInnerIterator()->seek($index);
    }


    /**
     * @return \ArrayIterator
     */
    public function getInnerIterator()
    {
        return parent::getInnerIterator();
    }
}
