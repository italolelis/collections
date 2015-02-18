<?php

namespace Collections;

use Collections\Iterator\IteratorCollectionTrait;
use Collections\Iterator\LinkedQueueIterator;

class LinkedQueue implements QueueInterface
{

    use GuardTrait;
    use IteratorCollectionTrait;

    /**
     * @var Pair
     */
    private $head;

    /**
     * @var Pair
     */
    private $tail;

    private $size = 0;

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->head === null;
    }


    /**
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return QueueIterator
     */
    public function getIterator()
    {
        return new LinkedQueueIterator($this->size, $this->head);
    }

    /**
     * @param $item
     * @return void
     */
    public function enqueue($item)
    {
        $pair = new Pair($item, null);

        if ($this->tail !== null) {
            $this->tail = $this->tail->second = $pair;
        } else {
            $this->head = $this->tail = $pair;
        }

        $this->size++;
    }

    /**
     * @return mixed
     * @throws StateException if the Queue is empty.
     */
    public function dequeue()
    {
        $this->emptyGuard(__METHOD__);
        $item = $this->head->first;
        $this->head = $this->head->second;
        $this->size--;

        return $item;
    }


    /**
     * Returns the first element in the Queue without removing it.
     * @return mixed
     * @throws StateException if the Queue is empty.
     */
    public function first()
    {
        $this->emptyGuard(__METHOD__);
        return $this->head->first;
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
     * @param mixed $item
     * @return bool
     */
    public function contains($item)
    {
        for ($n = $this->head; $n !== null; $n = $n->second) {
            if ($item == $n->first) {
                return true;
            }
        }
        return false;
    }


    /**
     * Empties the Queue.
     * @return void
     */
    public function clear()
    {
        $this->size = 0;
        $this->head = $this->tail = null;
    }

    /**
     * Adds multiples objects to the end of the Queue.
     * @param CollectionInterface|array $items The objects to add to the Queue. The value can be null.
     * @return Queue
     */
    public function enqueueMultiple($items)
    {
        // TODO: Implement enqueueMultiple() method.
    }
}
