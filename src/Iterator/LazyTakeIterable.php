<?php

namespace Collections\Iterator;

use Collections\Iterable;

class LazyTakeIterable implements Iterable
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
        return new LazyTakeIterator($this->iterable->getIterator(), $this->n);
    }
}

