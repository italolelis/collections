<?php

namespace Collections\Traits;

use Collections\Iterable;

trait ConstMapLikeTrait
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
            foreach ($it as $key => $value) {
                if (is_array($value)) {
                    $value = new static($value);
                }
                $coll[$key] = $value;
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
        $this->validateKeyDoesNotExists($key);

        return $this->container[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function get($index)
    {
        if ($this->containsKey($index)) {
            return $this->container[$index];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function containsKey($key)
    {
        return array_key_exists($key, $this->container);
    }

    /**
     * {@inheritdoc}
     */
    public function contains($element)
    {
        return in_array($element, $this->container, true);
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
        foreach ($this as $key => $value) {
            if ($value instanceof Iterable) {
                $arr[$key] = $value->toArray();
            } else {
                $arr[$key] = $value;
            }
        }

        return $arr;
    }
}
