<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

use BadFunctionCallException;

/**
 * Provides functionality to evaluate queries against a specific data source wherein the type of the data is not specified.
 */
interface IStack extends ICollection
{

    /**
     * Inserts an object at the top of the Stack.
     * @param type $item The Object to push onto the Stack. The value <b>can</b> be null.
     * @return Stack
     */
    public function push($item);

    /**
     * Inserts multiples objects at the top of the Stack.
     * @param  ICollection|array $items The Objects to push onto the Stack. The value <b>can</b> be null.
     * @return Stack
     */
    public function pushMultiple($items);

    /**
     * Removes and returns the object at the top of the Stack.
     * @return mixed The Object removed from the top of the Stack.
     * @throws BadFunctionCallException
     */
    public function pop();

    /**
     * Returns the object at the top of the Stack without removing it.
     * @return mixed The Object at the top of the Stack.
     * @throws BadFunctionCallException
     */
    public function peek();
}
