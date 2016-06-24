<?php

namespace Collections\Traits;

use Collections\ArrayList;
use Collections\Iterable;
use Collections\Iterator\LazyKeysIterable;
use Collections\MapInterface;
use Collections\Pair;

trait CommonMutableContainerTrait
{
    /**
     * {@inheritdoc}
     */
    public function addAll($items)
    {
        $this->validateTraversable($items);
        $isMap = $items instanceof MapInterface;

        foreach ($items as $key => $value) {
            if (is_array($value)) {
                $value = new static($value);
            }

            if ($isMap && !$value instanceof Pair) {
                $value = new Pair($key, $value);
            }

            $this->add($value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function values()
    {
        return new ArrayList($this);
    }

    public function keys()
    {
        return new ArrayList(new LazyKeysIterable($this));
    }

    /**
     * {@inheritDoc}
     */
    public function concat($iterable)
    {
        if ($iterable instanceof Iterable) {
            $iterable = $iterable->toArray();
        }

        return new static(array_merge_recursive($this->toArray(), $iterable));
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $old = $this->container;

        $this->container = [];

        unset($old);

        return $this;
    }
}
