<?php

namespace Collections\Iterator;

use Collections\KeyedIterable;

class LazySliceKeyedIterable implements KeyedIterable
{
    use LazyKeyedIterableTrait;

    /**
     * @var KeyedIterable
     */
    private $Enumerable;

    /**
     * @var int
     */
    private $start;

    /**
     * @var int
     */
    private $len;

    public function __construct($Enumerable, $start, $len)
    {
        $this->Enumerable = $Enumerable;
        $this->start = $start;
        $this->len = $len;
    }

    public function getIterator()
    {
        return new LazySliceKeyedIterator($this->Enumerable->getIterator(), $this->start, $this->len);
    }
}
