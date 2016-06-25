<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections\Comparer;

use Collections\Generic\ComparerInterface;

/**
 * Represents a string comparison operation that uses specific case and culture-based or ordinal comparison rules.
 */
class StringComparer implements ComparerInterface
{
    /**
     * {@inheritdoc}
     */
    public function compare($first, $second)
    {
        return strcmp($first, $second);
    }
}
