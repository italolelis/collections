<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections\Comparer;

use Easy\Collections\Generic\ComparerInterface;

class StringComparer implements ComparerInterface
{

    public function compare($x, $y)
    {
        return strcmp($x, $y);
    }

}