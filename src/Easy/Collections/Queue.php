<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Easy\Collections;

use RuntimeException;
use SplQueue;

/**
 * Represents a first-in, first-out collection of objects.
 */
class Queue extends SplQueue implements QueueInterface
{

    /**
     * Adds multiples objects to the end of the Queue.
     * @param CollectionInterface|array $items The objects to add to the Queue. The value can be null.
     */
    public function enqueueMultiple($items)
    {
        foreach ($items as $item) {
            $this->enqueue($item);
        }
        return $this;
    }

    /**
     * Returns the object at the beginning of the Queue without removing it.
     * @return mixed The object at the beginning of the Queue.
     * @throws RuntimeException
     */
    public function peek()
    {
        if ($this->isEmpty()) {
            throw new RuntimeException(_('Cannot use method Peek on an empty Queue'));
        }

        return $this->offsetGet(0);
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
}
