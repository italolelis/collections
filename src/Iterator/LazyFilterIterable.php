<?php

namespace Collections\Iterator;

use Collections\Enumerable;

class LazyFilterIterable implements Enumerable
{
    use LazyIterableTrait;

    /**
     * @var Enumerable
     */
    private $Enumerable;

    /**
     * @var callable
     */
    private $fn;

    public function __construct($Enumerable, $fn)
    {
        $this->Enumerable = $Enumerable;
        $this->fn = $fn;
    }

    public function getIterator()
    {
        return new LazyFilterIterator($this->Enumerable->getIterator(), $this->fn);
    }
}
