<?php

namespace Collections\Traits;

use Collections\Pair;

trait MapLikeTrait
{
    use ConstMapLikeTrait,
        CommonMutableContainerTrait;

    /**
     * identical to at, implemented for ArrayAccess
     */
    public function offsetGet($offset)
    {
        return $this->at($offset);
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->add($value);
        } else {
            $this->set($offset, $value);
        }
    }

    public function offsetUnset($offset)
    {
        $this->removeKey($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        $this->container[$key] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setAll($items)
    {
        $this->validateTraversable($items);

        foreach ($items as $key => $item) {
            if (is_array($item)) {
                $item = new static($item);
            }
            $this->set($key, $item);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function add($pair)
    {
        if (!($pair instanceof Pair)) {
            throw new \InvalidArgumentException('Parameter must be an instance of Pair');
        }

        list($key, $value) = $pair;

        $this->validateKeyExists($key);
        $this->set($key, $value);

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
     * {@inheritDoc}
     * @return $this
     */
    public function each(callable $callable)
    {
        foreach ($this as $k => $v) {
            $callable($v, $k);
        }

        return $this;
    }
}
