<?php

namespace Collections\Traits;

use Collections\Exception\InvalidOperationException;

trait VectorLikeTrait
{
    use ConstVectorLikeTrait,
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
        throw InvalidOperationException::unsupportedUnset($this);
    }

    /**
     * Stores a value into the Vector with the specified key, overwriting the
     * previous value associated with the key. If the key is not present,
     * an exception is thrown. "$vec->set($k,$v)" is semantically equivalent
     * to "$vec[$k] = $v" (except that set() returns the Vector).
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function set($key, $value)
    {
        $this->validateKeyType($key);
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
    public function add($item)
    {
        $this->container[] = $item;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeKey($key)
    {
        $this->validateKeyType($key);
        $this->validateKeyBounds($key);

        array_splice($this->container, $key, 1);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function splice($offset, $length = null)
    {
        if (!is_int($offset)) {
            throw new \InvalidArgumentException('Parameter offset must be an integer');
        }

        if (!is_null($length) && !is_int($length)) {
            throw new \InvalidArgumentException('Parameter len must be null or an integer');
        }

        $removed = is_null($length) ? array_splice($this->container, $offset) :
            array_splice($this->container, $offset, $len);

//        if (count($removed) > 0) {
//            $this->hacklib_expireAllIterators();
//        }
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
