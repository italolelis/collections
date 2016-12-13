<?php

namespace Collections\Iterator;

use Collections\Enumerable;

class LazyKeysIterable implements Enumerable
{
    use LazyIterableTrait;

    /**
     * @var Enumerable
     */
    private $Enumerable;

    public function __construct($Enumerable)
    {
        $this->Enumerable = $Enumerable;
    }

    public function getIterator()
    {
        return new LazyKeysIterator($this->Enumerable->getIterator());
    }
}
