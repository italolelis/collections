<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections\Comparer;

use Collections\Generic\ComparerInterface;

/**
 * Represents a numeric key comparison operation that uses specific case and culture-based or ordinal comparison rules.
 */
class NumericKeyComparer implements ComparerInterface
{

    /**
     * {@inheritdoc}
     */
    public function compare($first, $second)
    {
        if ($first < $second) {
            return 1;
        } elseif ($first === $second) {
            return 0;
        } else {
            return -1;
        }
    }
}
