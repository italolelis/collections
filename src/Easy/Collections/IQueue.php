<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

use BadFunctionCallException;

/**
 * Provides functionality to evaluate queries against a specific data source wherein the type of the data is not specified.
 */
interface IQueue extends ICollection
{

    /**
     * Adds an object to the end of the Queue.
     * @param mixed $item The object to add to the Queue. The value can be null.
     * @return Queue
     */
    public function enqueue($item);

    /**
     * Adds multiples objects to the end of the Queue.
     * @param ICollection|array $items The objects to add to the Queue. The value can be null.
     * @return Queue
     */
    public function enqueueMultiple($items);

    /**
     * Removes and returns the object at the beginning of the Queue.
     * @return mixed The object that is removed from the beginning of the Queue.
     * @throws BadFunctionCallException
     */
    public function dequeue();

    /**
     * Returns the object at the beginning of the Queue without removing it.
     * @return mixed The object at the beginning of the Queue.
     * @throws BadFunctionCallException
     */
    public function peek();
}
