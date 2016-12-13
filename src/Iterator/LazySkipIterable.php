<?php

namespace Collections\Iterator;


use Collections\Enumerable;

class LazySkipIterable implements Enumerable
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
        return new LazySkipIterator($this->Enumerable->getIterator(), $this->n);
    }
}

