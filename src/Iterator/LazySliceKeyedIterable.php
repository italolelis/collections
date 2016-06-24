<?php

namespace Collections\Iterator;

use Collections\KeyedIterable;

class LazySliceKeyedIterable implements KeyedIterable
{
    use LazyKeyedIterableTrait;

    /**
     * @var KeyedIterable
     */
    private $iterable;

    /**
     * @var int
     */
    private $start;

    /**
     * @var int
     */
    private $len;

    public function __construct($iterable, $start, $len)
    {
        $this->iterable = $iterable;
        $this->start = $start;
        $this->len = $len;
    }

    public function getIterator()
    {
        return new LazySliceKeyedIterator($this->iterable->getIterator(), $this->start, $this->len);
    }
}
