<?php

namespace Collections\Iterator;

use Iterator;

interface CountableIterator extends \Countable, Iterator
{

    /**
     * @return bool
     */
    function isEmpty();

}
