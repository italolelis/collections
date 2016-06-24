<?php

namespace Collections\Iterator;

use Collections\Iterable;

class LazyConcatIterable implements Iterable
{
    use LazyIterableTrait;

    /**
     * @var Iterable
     */
    private $iterable1;

    /**
     * @var Iterable
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
