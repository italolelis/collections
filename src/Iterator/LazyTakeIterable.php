<?php

namespace Collections\Iterator;

use Collections\Enumerable;

class LazyTakeIterable implements Enumerable
{
    use LazyIterableTrait;

    /**
     * @var Enumerable
     */
    private $Enumerable;

    /**
     * @var int
     */
    private $n;

    public function __construct($Enumerable, $n)
    {
        $this->Enumerable = $Enumerable;
        $this->n = $n;
    }

    public function getIterator()
    {
        return new LazyTakeIterator($this->Enumerable->getIterator(), $this->n);
    }
}

