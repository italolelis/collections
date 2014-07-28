<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Easy\Collections;

use BadFunctionCallException;

/**
 * Represents a simple last-in-first-out (LIFO) non-generic collection of objects.
 */
class Stack extends AbstractCollection implements IStack
{

    /**
     * Inserts an object at the top of the Stack.
     * @param type $item The Object to push onto the Stack. The value <b>can</b> be null.
     */
    public function push($item)
    {
        array_push($this->array, $item);
        return $this;
    }

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
     * Removes and returns the object at the top of the Stack.
     * @return mixed The Object removed from the top of the Stack.
     * @throws BadFunctionCallException
     */
    public function pop()
    {
        if ($this->isEmpty()) {
            throw new BadFunctionCallException(_('Cannot use method Pop on an empty Stack'));
        }
        return array_pop($this->array);
    }

    /**
     * Returns the object at the top of the Stack without removing it.
     * @return mixed The Object at the top of the Stack.
     * @throws BadFunctionCallException
     */
    public function peek()
    {
        if ($this->isEmpty()) {
            throw new BadFunctionCallException(_('Cannot use method Peek on an empty Stack'));
        }

        return end($this->array);
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
}