<?php

namespace Collections\Iterator;

use Iterator;

interface CountableIteratorInterface extends \Countable, Iterator
{

    /**
     * @return bool
     */
    function isEmpty();

}
