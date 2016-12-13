<?php

namespace Collections\Traits;

use Collections\Exception\ElementAlreadyExists;
use Collections\Exception\InvalidOperationException;

trait SetLikeTrait
{
    use ConstSetLikeTrait,
        CommonMutableContainerTrait;

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->add($value);
        } else {
            throw new InvalidOperationException('[] operator cannot be used to modify elements of a Set');
        }
    }

    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function removeKey($key)
    {
        $this->validateKeyDoesNotExists($key);

        unset($this->container[$key]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($element)
    {
        $key = array_search($element, $this->container);

        if (false === $key) {
            throw new \OutOfBoundsException('No element found in the collection');
        }

        $this->removeKey($key);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function removeAll($traversable)
    {
        foreach ($traversable as $item) {
            if ($this->contains($item)) {
                $this->remove($item);
            }
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function each(callable $callable)
    {
        foreach ($this as $v) {
            $callable($v);
        }

        return $this;
    }
}
