<?php

namespace Collections;

use Collections\Exception\ElementAlreadyExists;
use Collections\Exception\UnsuportedException;
use Collections\Iterator\SetIterator;
use Collections\Traits\GuardTrait;
use Collections\Traits\StrictKeyedIterableTrait;

class Set extends AbstractConstCollectionArray implements SetInterface, \ArrayAccess
{
    use GuardTrait,
        StrictKeyedIterableTrait;

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
    public function addAll($items)
    {
        $this->validateTraversable($items);

        foreach ($items as $value) {
            $this->add($value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function remove($element)
    {
        $key = array_search($element, $this->container, true);
        unset($this->container[$key]);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new SetIterator($this->container);
    }

    /**
     * @inheritDoc
     */
    public function add($item)
    {
        if ($this->contains($item)) {
            throw ElementAlreadyExists::duplicatedElement($item);
        }

        $this->container[] = $item;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function removeAll(Iterable $iterable)
    {
        $iterable->each(function ($item) {
            if ($this->contains($item)) {
                $this->remove($item);
            }
        });

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return $this->getIterator()->offsetExists($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        throw UnsuportedException::unsupportedGet($this);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if (!is_null($offset)) {
            throw UnsuportedException::unsupportedSetKey($this);
        }

        $this->add($value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        throw UnsuportedException::unsupportedUnset($this);
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function concat($iterable)
    {
        $this->validateTraversable($iterable);

        $concatenated = $this->concatRecurse($this, $iterable);
        $this->clear();
        $this->addAll($concatenated);

        return $this;
    }
}
