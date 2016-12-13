<?php

namespace Collections\Iterator;

use Collections\KeyedIterable;

class LazyFilterKeyedIterable implements KeyedIterable
{
    use LazyKeyedIterableTrait;

    /**
     * @var KeyedIterable
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
        return
            new LazyFilterKeyedIterator($this->Enumerable->getIterator(), $this->fn);
    }
}
