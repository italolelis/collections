<?php

namespace Collections\Iterator;

use Collections\Exception\TypeException;
use Collections\Pair;

class SortedMapIterator extends IteratorCollectionAdapter implements MapIteratorInterface
{

    private $size = 0;


    public function __construct(InOrderIterator $iterator, $size)
    {
        parent::__construct($iterator);
        $this->size = $size;
        $this->rewind();
    }


    public function count()
    {
        return $this->size;
    }


    /**
     * @link https://bugs.php.net/bug.php?id=45684
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed
     * @throws TypeException
     */
    public function key()
    {
        return $this->pairGuard($this->inner->current())->first;
    }


    /**
     * @link http://php.net/manual/en/iterator.current.php
     * @throws TypeException
     * @return mixed
     */
    public function current()
    {
        return $this->pairGuard($this->inner->current())->second;
    }


    /**
     * @param mixed $pair
     * @return Pair
     * @throws TypeException
     */
    private function pairGuard($pair)
    {
        if (!($pair instanceof Pair)) {
            throw new TypeException(
                __CLASS__ . ' only works with a BinarySearchTreeIterator that returns pair objects as values'
            );
        }
        return $pair;
    }


}
