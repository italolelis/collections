<?php

namespace Collections\Iterator;

use Collections\KeyedIterable;

class LazyMapKeyedIterable implements KeyedIterable
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
        return new LazyMapKeyedIterator($this->Enumerable->getIterator(), $this->fn);
    }
}

