<?php

namespace Collections\Iterator;

use Collections\Iterable;

class LazyKeysIterable implements Iterable
{
    use LazyIterableTrait;

    /**
     * @var Iterable
     */
    private $iterable;

    public function __construct($iterable)
    {
        $this->iterable = $iterable;
    }

    public function getIterator()
    {
        return new LazyKeysIterator($this->iterable->getIterator());
    }
}
