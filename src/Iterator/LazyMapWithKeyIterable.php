<?php

namespace Collections\Iterator;

use Collections\KeyedIterable;

class LazyMapWithKeyIterable implements KeyedIterable
{
    use LazyKeyedIterableTrait;

    /**
     * @var KeyedIterable
     */
    private $iterable;

    /**
     * @var callable
     */
    private $fn;

    public function __construct($iterable, $fn)
    {
        $this->iterable = $iterable;
        $this->fn = $fn;
    }

    public function getIterator()
    {
        return new LazyMapWithKeyIterator($this->iterable->getIterator(), $this->fn);
    }
}

