<?php

namespace Collections\Traits;

use Collections\Immutable\ImmVector;
use Collections\Iterator\LazyConcatIterator;
use Collections\Iterator\LazyKeysIterable;

trait CommonImmMutableContainerTrait
{
    /**
     * {@inheritdoc}
     */
    public function values()
    {
        return $this->toImmVector();
    }

    public function keys()
    {
        return new ImmVector(new LazyKeysIterable($this));
    }

    /**
     * {@inheritDoc}
     */
    public function concat($iterable)
    {
        if (is_array($iterable)) {
            $iterable = new ImmVector($iterable);
        }

        if ($iterable instanceof \Traversable) {
            return new ImmVector(new LazyConcatIterator($this, $iterable));
        } else {
            throw new \InvalidArgumentException('Parameter must be an array or an instance of Traversable');
        }
    }
}
