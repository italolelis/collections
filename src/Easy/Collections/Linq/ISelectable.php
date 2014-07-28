<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections\Linq;

use Easy\Collections\ArrayList;

/**
 * Represents a non-generic collection of objects that can be individually accessed by index.
 */
interface ISelectable
{

    /**
     * Selects all elements from a selectable that match the expression and
     * returns a new collection containing these elements.
     *
     * @param Criteria $criteria
     *
     * @return ArrayList
     */
    public function matching(Criteria $criteria);
}
