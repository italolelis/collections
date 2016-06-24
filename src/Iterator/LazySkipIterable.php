<?php

namespace Collections\Iterator;


use Collections\Iterable;

class LazySkipIterable implements Iterable
{
    use LazyIterableTrait;

    /**
     * @var Iterable
     */
    private $iterable;

    /**
     * @var int
     */
    private $n;

    public function __construct($iterable, $n)
    {
        $this->iterable = $iterable;
        $this->n = $n;
    }

    public function getIterator()
    {
        return new LazySkipIterator($this->iterable->getIterator(), $this->n);
    }
}

