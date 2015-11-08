<?php

namespace Collections\Traits;

use Collections\Dictionary;
use Collections\Immutable\ImmDictionary;

trait StrictKeyedIterableTrait
{
    public function toMap()
    {
        return new Dictionary($this->getIterator());
    }

    public function toImmMap()
    {
        return new ImmDictionary($this->getIterator());
    }

    /**
     * {@inheritdoc}
     */
    public function toKeysArray()
    {
        return $this->getIterator()->keys()->toArray();
    }
}
