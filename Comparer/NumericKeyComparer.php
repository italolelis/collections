<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections\Comparer;

use Easy\Collections\Generic\ComparerInterface;

class NumericKeyComparer implements ComparerInterface
{

    public function compare($x, $y)
    {
        if ($x < $y) {
            return 1;
        } elseif ($x === $y) {
            return 0;
        } else {
            return -1;
        }
    }

}