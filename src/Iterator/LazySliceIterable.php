<?php

namespace Collections\Iterator;

use Collections\Enumerable;

class LazySliceIterable implements Enumerable
{
    use LazyIterableTrait;

    /**
     * @var Enumerable
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
        return new LazySliceIterator($this->Enumerable->getIterator(), $this->start, $this->len);
    }
}
