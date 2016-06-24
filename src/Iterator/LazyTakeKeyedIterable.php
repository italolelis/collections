<?php

namespace Collections\Iterator;

use Collections\KeyedIterable;

class LazyTakeKeyedIterable implements KeyedIterable
{
    use LazyKeyedIterableTrait;

    /**
     * @var KeyedIterable
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
        return new LazyTakeKeyedIterator($this->iterable->getIterator(), $this->n);
    }
}
