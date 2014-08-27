<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Easy\Collections\Comparer;

use Easy\Collections\Generic\ComparerInterface;

/**
 * Represents a string comparison operation that uses specific case and culture-based or ordinal comparison rules.
 */
class StringComparer implements ComparerInterface
{

    /**
     * Compares two objects and returns a value indicating whether one is less than, equal to, or greater than the other.
     * @param string $x The first object to compare.
     * @param string $y The second object to compare.
     * @return bool A boolean that indicates the relative values of x and y, as shown in the following table.
     */
    public function compare($x, $y)
    {
        return (bool) strcmp($x, $y);
    }
}
