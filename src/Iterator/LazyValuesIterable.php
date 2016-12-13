<?php

namespace Collections\Iterator;

use Collections\Enumerable;

class LazyValuesIterable implements Enumerable
{
    use LazyIterableTrait;

    /**
     * @var Enumerable
     */
    private $Enumerable;

    public function __construct($Enumerable)
    {
        $this->Enumerable = $Enumerable;
    }

    public function getIterator()
    {
        return new LazyValuesIterator($this->Enumerable->getIterator());
    }
}
