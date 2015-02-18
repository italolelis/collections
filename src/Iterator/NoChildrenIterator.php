<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections\Iterator;

use IteratorIterator;
use RecursiveIterator;

/**
 * An iterator that can be used as argument for other iterators that require
 * a RecursiveIterator, but that will always report as having no nested items.
 */
class NoChildrenIterator extends IteratorIterator implements RecursiveIterator
{
    /**
     * Returns false as there are no children iterators in this collection
     *
     * @return bool
     */
    public function hasChildren()
    {
        return false;
    }

    /**
     * Returns null as there are no children for this iteration level
     *
     * @return null
     */
    public function getChildren()
    {
        return null;
    }
}