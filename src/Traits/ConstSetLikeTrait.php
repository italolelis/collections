<?php

namespace Collections\Traits;

use Collections\Iterable;

trait ConstSetLikeTrait
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
     * identical to at, implemented for ArrayAccess
     */
    public function offsetGet($offset)
    {
        return $this->container[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return $this->containsKey($offset);
    }

    /**
     * {@inheritdoc}
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
     * Returns an array containing the values from this VectorLike.
     */
    public function toArray()
    {
        $arr = [];
        foreach ($this as $k => $v) {
            if ($v instanceof Iterable) {
                $arr[] = $v->toArray();
            } else {
                $arr[] = $v;
            }
        }

        return $arr;
    }
}
