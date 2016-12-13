<?php

namespace Collections\Iterator;

use Collections\Enumerable;

class LazyConcatIterable implements Enumerable
{
    use LazyIterableTrait;

    /**
     * @var Enumerable
     */
    private $iterable1;

    /**
     * @var Enumerable
     */
    private $iterable2;

    public function __construct($iterable1, $iterable2)
    {
        $this->iterable1 = $iterable1;
        $this->iterable2 = $iterable2;
    }

    public function getIterator()
    {
        return new LazyConcatIterator($this->iterable1->getIterator(), $this->iterable2->getIterator());
    }
}
