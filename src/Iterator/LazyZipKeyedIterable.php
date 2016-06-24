<?php

namespace Collections\Iterator;

use Collections\KeyedIterable;

class LazyZipKeyedIterable implements KeyedIterable
{
    use LazyKeyedIterableTrait;

    /**
     * @var KeyedIterable
     */
    private $iterable1;

    /**
     * @var KeyedIterable
     */
    private $iterable2;

    public function __construct($iterable1, $iterable2)
    {
        $this->iterable1 = $iterable1;
        $this->iterable2 = $iterable2;
    }

    public function getIterator()
    {
        return new LazyZipKeyedIterator($this->iterable1->getIterator(), $this->iterable2->getIterator());
    }
}