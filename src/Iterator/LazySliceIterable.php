<?php

namespace Collections\Iterator;

use Collections\Iterable;

class LazySliceIterable implements Iterable
{
    use LazyIterableTrait;

    /**
     * @var Iterable
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
        return new LazySliceIterator($this->iterable->getIterator(), $this->start, $this->len);
    }
}