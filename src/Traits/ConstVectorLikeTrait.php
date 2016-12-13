<?php

namespace Collections\Traits;

use Collections\Enumerable;

trait ConstVectorLikeTrait
{
    use CommonContainerMethodsTrait;

    /**
     * @var array
     */
    private $container;

    protected function init($it = null)
    {
        if (null !== $it) {
            $this->validateTraversable($it);

            $coll = [];
            foreach ($it as $value) {
                if (is_array($value)) {
                    $value = new static($value);
                }
                $coll[] = $value;
            }
            $this->container = $coll;
        } else {
            $this->container = [];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty()
    {
        return $this->count() === 0;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->container);
    }

    /**
     * {@inheritdoc}
     */
    public function at($key)
    {
        $this->validateKeyType($key);
        $this->validateKeyBounds($key);

        return $this->container[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function get($index)
    {
        $this->validateKeyType($index);

        return $this->container[$index];
    }

    /**
     * {@inheritdoc}
     */
    public function containsKey($key)
    {
        $this->validateKeyType($key);

        return $key >= 0 && $key < $this->count();
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return $this->containsKey($offset) && $this->at($offset) !== null;
    }

    /**
     * Returns an array containing the values from this VectorLike.
     */
    public function toArray()
    {
        $arr = [];
        foreach ($this as $k => $v) {
            if ($v instanceof Enumerable) {
                $arr[] = $v->toArray();
            } else {
                $arr[] = $v;
            }
        }

        return $arr;
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
