<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

use Collections\Iterator\LinkedQueueIterator;
use SplQueue;

/**
 * Represents a first-in, first-out collection of objects.
 */
class Queue extends SplQueue
{

    /**
     * Adds multiples objects to the end of the Queue.
     * @param CollectionInterface|array $items The objects to add to the Queue. The value can be null.
     * @return $this|Queue
     */
    public function enqueueMultiple($items)
    {
        foreach ($items as $item) {
            $this->enqueue($item);
        }
        return $this;
    }

    public static function fromArray(array $arr)
    {
        $collection = new Queue();
        foreach ($arr as $v) {
            if (is_array($v)) {
                $collection->enqueue(static::fromArray($v));
            } else {
                $collection->enqueue($v);
            }
        }
        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $array = array();
        foreach ($this as $key => $value) {
            if ($value instanceof CollectionInterface) {
                $array[$key] = $value->toArray();
            } else {
                $array[$key] = $value;
            }
        }
        return $array;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return get_class($this);
    }

    /**
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return QueueIterator
     */
    public function getIterator()
    {
        return new LinkedQueueIterator($this->count(), $this->top());
    }
}
