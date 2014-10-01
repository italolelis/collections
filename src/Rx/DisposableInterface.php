<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Easy\Collections\Rx;

/**
 * Defines a method to release allocated resources.
 */
interface DisposableInterface
{

    /**
     * Performs application-defined tasks associated with freeing, releasing, or resetting resources.
     */
    public function dispose();
}
