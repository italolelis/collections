<?php

namespace Collections;

use Collections\Iterator\SetIterator;
use Collections\Traits\GuardTrait;
use Collections\Traits\StrictKeyedIterableTrait;

class Set extends AbstractCollectionArray implements SetInterface
{
    use GuardTrait,
        StrictKeyedIterableTrait;

    public function at($k)
    {
        return $this[$k];
    }

    /**
     * @inheritDoc
     */
    public function get($key)
    {
        $this->validateKeyBounds($key);

        return $this->container[$key];
    }

    /**
     * @inheritDoc
     */
    public function containsKey($key)
    {
        return array_key_exists($key, $this->container);
    }

    /**
     * @inheritDoc
     */
    public function contains($item)
    {
        return in_array($item, $this->container, true);
    }

    /**
     * @inheritDoc
     */
    public function set($key, $value)
    {
        $this->container[$key] = $value;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addAll($items)
    {
        if (!is_array($items) && !$items instanceof \Traversable) {
            throw new \InvalidArgumentException('The items must be an array or Traversable');
        }

        foreach ($items as $value) {
            $this->add($value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function remove($element)
    {
        $key = array_search($element, $this->container);
        $this->removeKey($key);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeKey($key)
    {
        $this->validateKeyBounds($key);
        unset($this->container[$key]);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new SetIterator();
    }

    /**
     * @inheritDoc
     */
    public function add($item)
    {
        $this->container[] = $item;

        return $this;
    }

    public function removeAll(Iterable $iterable)
    {
        $iterable->each(function ($item) {
            if ($this->contains($item)) {
                $this->remove($item);
            }
        });
    }
}
