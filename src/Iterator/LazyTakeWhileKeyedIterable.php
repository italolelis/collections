<?php

namespace Collections\Iterator;

use Collections\Enumerable;

class LazyTakeWhileKeyedIterable implements Enumerable
{
    use LazyIterableTrait;

    /**
     * @var Enumerable
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
        return new LazyTakeWhileKeyedIterator($this->Enumerable->getIterator(), $this->fn);
    }
}
