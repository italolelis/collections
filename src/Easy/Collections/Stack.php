<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Easy\Collections;

use RuntimeException;
use SplStack;

/**
 * Represents a simple last-in-first-out (LIFO) non-generic collection of objects.
 */
class Stack extends SplStack implements StackInterface
{

    /**
     * Inserts multiples objects at the top of the Stack.
     * @param type $items The Objects to push onto the Stack. The value <b>can</b> be null.
     */
    public function pushMultiple($items)
    {
        foreach ($items as $item) {
            $this->push($item);
        }
        return $this;
    }

    /**
     * Returns the object at the top of the Stack without removing it.
     * @return mixed The Object at the top of the Stack.
     * @throws RuntimeException
     */
    public function peek()
    {
        if ($this->isEmpty()) {
            throw new RuntimeException(_('Cannot use method Peek on an empty Stack'));
        }

        return $this->offsetGet(0);
    }

    public static function fromArray(array $arr)
    {
        $collection = new Stack();
        foreach ($arr as $v) {
            if (is_array($v)) {
                $collection->push(static::fromArray($v));
            } else {
                $collection->push($v);
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
