<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections\Comparer;

use Easy\Collections\Generic\IComparer;

/**
 * Represents a string comparison operation that uses specific case and culture-based or ordinal comparison rules.
 */
class StringComparer implements IComparer
{

    /**
     * {@inheritdoc}
     */
    public function compare($x, $y)
    {
        return strcmp($x, $y);
    }

}