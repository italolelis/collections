<?php

namespace Collections;

use Collections\Iterator\IteratorCollectionTrait;
use Collections\Iterator\LinkedStackIterator;

class LinkedStack implements StackInterface
{

    use GuardTrait;
    use IteratorCollectionTrait;

    /**s
     * @var Pair
     */
    private $top;

    private $size = 0;


    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->top === null;
    }


    /**
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return StackIterator
     */
    public function getIterator()
    {
        return new LinkedStackIterator($this->size, $this->top);
    }


    /**
     * @link http://php.net/manual/en/countable.count.php
     * @return int
     */
    public function count()
    {
        return $this->size;
    }

    /**
     * @param mixed $object
     *
     * @throws TypeException if $object is not the correct type.
     * @throws FullException if the Stack is full.
     * @return void
     */
    public function push($object)
    {
        $this->top = new Pair($object, $this->top);
        $this->size++;
    }


    /**
     * @throws EmptyException if the Stack is empty.
     * @return mixed
     */
    public function pop()
    {
        $this->emptyGuard(__METHOD__);

        list($value, $this->top) = [$this->top->first, $this->top->second];
        $this->size--;

        return $value;
    }


    /**
     * @throws EmptyException if the Stack is empty.
     * @return mixed
     */
    public function last()
    {
        $this->emptyGuard(__METHOD__);
        return $this->top->first;
    }


    public function clear()
    {
        $this->top = null;
        $this->size = 0;
    }


    /**
     * @return array
     */
    public function toArray()
    {
        $a = [];
        $current = $this->top;
        while ($current !== null) {
            $a[] = $current->first;
            $current = $current->second;
        }
        return $a;
    }


    /**
     * Inserts multiples objects at the top of the Stack.
     * @param  CollectionInterface|array $items The Objects to push onto the Stack. The value <b>can</b> be null.
     * @return Stack
     */
    public function pushMultiple($items)
    {
        // TODO: Implement pushMultiple() method.
    }
}
