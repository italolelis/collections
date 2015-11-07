<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

use BadFunctionCallException;

/**
 * Provides functionality to evaluate queries against a specific data source wherein the type of the data
 * is not specified.
 */
interface StackInterface
{

    /**
     * Inserts an object at the top of the Stack.
     * @param mixed $item The Object to push onto the Stack. The value <b>can</b> be null.
     * @return Stack
     */
    public function push($item);

    /**
     * Inserts multiples objects at the top of the Stack.
     * @param  CollectionInterface|array $items The Objects to push onto the Stack. The value <b>can</b> be null.
     * @return Stack
     */
    public function pushMultiple($items);

    /**
     * Removes and returns the object at the top of the Stack.
     * @return mixed The Object removed from the top of the Stack.
     * @throws BadFunctionCallException
     */
    public function pop();
}
