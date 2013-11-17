<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

use BadFunctionCallException;
use Easy\Collections\CollectionArray;

/**
 * Represents a simple last-in-first-out (LIFO) non-generic collection of objects.
 */
class Stack extends CollectionArray implements StackInterface
{

    /**
     * Inserts an object at the top of the Stack.
     * @param type $item The Object to push onto the Stack. The value <b>can</b> be null.
     */
    public function push($item)
    {
        array_push($this->array, $item);
    }

    /**
     * Inserts multiples objects at the top of the Stack.
     * @param type $item The Objects to push onto the Stack. The value <b>can</b> be null.
     */
    public function pushMultiple($items)
    {
        $this->addMultiple($items);
    }

    /**
     * Removes and returns the object at the top of the Stack.
     * @return mixed The Object removed from the top of the Stack.
     * @throws BadFunctionCallException
     */
    public function pop()
    {
        if ($this->isEmpty()) {
            throw new BadFunctionCallException(__('Cannot use method Pop on an empty Stack'));
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
            throw new BadFunctionCallException(__('Cannot use method Peek on an empty Stack'));
        }

        return end($this->array);
    }

}
