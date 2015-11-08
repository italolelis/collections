<?php

namespace Collections\Traits;

use Collections\ArrayList;
use Collections\Immutable\ImmArrayList;
use Collections\Immutable\ImmSet;

trait StrictIterableTrait
{
    public function toArray()
    {
        return $this->getIterator()->toArray();
    }

    public function toValuesArray()
    {
        return array_values($this->toArray());
    }

    public function toVector()
    {
        return new ArrayList($this->getIterator());
    }

    public function toImmVector()
    {
        return new ImmArrayList($this->getIterator());
    }

    public function toSet()
    {
        // TODO: Implement toSet() method.
    }

    public function toImmSet()
    {
        return new ImmSet($this->getIterator());
    }

    public function lazy()
    {
        // TODO: Implement lazy() method.
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function first()
    {
        $result = $this->toArray();

        return array_shift($result);
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function last()
    {
        $result = $this->toArray();

        return array_pop($result);
    }

    public function skip($n)
    {

    }
}
