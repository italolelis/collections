<?php

namespace Collections\Traits;

use Collections\Comparer\NumericKeyComparer;
use Collections\Generic\ComparerInterface;
use Collections\Immutable\ImmVector;
use Collections\Immutable\ImmMap;
use Collections\Immutable\ImmSet;
use Collections\Iterable;
use Collections\Iterator\LazyFilterIterable;
use Collections\Iterator\LazyFilterKeyedIterable;
use Collections\Iterator\LazyMapIterable;
use Collections\Iterator\LazyMapWithKeyIterable;
use Collections\Iterator\LazySkipIterable;
use Collections\Iterator\LazySkipWhileIterable;
use Collections\Iterator\LazySliceIterable;
use Collections\Iterator\LazyTakeIterable;
use Collections\Iterator\LazyTakeWhileIterable;
use Collections\Iterator\LazyZipIterable;
use Collections\Map;
use Collections\Pair;
use Collections\Set;
use Collections\Vector;
use Collections\VectorInterface;

trait CommonContainerMethodsTrait
{
    use GuardTrait;
    /**
     * @var ComparerInterface
     */
    private $defaultComparer;

    /**
     * Gets the default comparer for this collection
     * @return ComparerInterface
     */
    public function getDefaultComparer()
    {
        if ($this->defaultComparer === null) {
            $this->defaultComparer = new NumericKeyComparer();
        }

        return $this->defaultComparer;
    }

    /**
     * Sets the default comparer for this collection
     * @param ComparerInterface $defaultComparer
     * @return $this
     */
    public function setDefaultComparer(ComparerInterface $defaultComparer)
    {
        $this->defaultComparer = $defaultComparer;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return get_class($this);
    }

    public function equals($obj)
    {
        return ($obj === $this);
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize($this->container);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $this->container = unserialize($serialized);

        return $this->container;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->container;
    }

    /**
     * @return array
     */
    public function toValuesArray()
    {
        $arr = [];
        foreach ($this as $value) {
            if ($value instanceof Iterable) {
                $arr[] = $value->toArray();
            } else {
                $arr[] = $value;
            }
        }

        return $arr;
    }

    public function toKeysArray()
    {
        $res = [];
        foreach ($this as $k => $_) {
            $res[] = $k;
        }

        return $res;
    }

    /**
     * {@inheritdoc}
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

    /**
     * {@inheritdoc}
     */
    public static function fromArray(array $arr)
    {
        $map = new static();
        foreach ($arr as $k => $v) {
            if (is_array($v)) {
                $map[$k] = new static($v);
            } else {
                $map[$k] = $v;
            }
        }

        return $map;
    }

    /**
     * {@inheritdoc}
     */
    public function toVector()
    {
        return new Vector($this);
    }

    /**
     * {@inheritdoc}
     */
    public function toImmVector()
    {
        return new ImmVector($this);
    }

    /**
     * {@inheritdoc}
     */
    public function toSet()
    {
        return new Set($this);
    }

    /**
     * {@inheritdoc}
     */
    public function toImmSet()
    {
        return new ImmSet($this);
    }

    /**
     * {@inheritdoc}
     */
    public function toMap()
    {
        return new Map($this);
    }

    /**
     * {@inheritdoc}
     */
    public function toImmMap()
    {
        return new ImmMap($this);
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function map(callable $callable)
    {
        return new static(new LazyMapIterable($this, $callable));
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function mapWithKey($callback)
    {
        return new static(new LazyMapWithKeyIterable($this, $callback));
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function filter(callable $callable)
    {
        return new static(new LazyFilterIterable($this, $callable));
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function filterWithKey($callback)
    {
        return new static(new LazyFilterKeyedIterable($this, $callback));
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function zip($traversable)
    {
        if (is_array($traversable)) {
            $traversable = new ImmVector($traversable);
        }

        if ($traversable instanceof \Traversable) {
            return new static(new LazyZipIterable($this, $traversable));
        } else {
            throw new \InvalidArgumentException('Parameter must be an array or an instance of Traversable');
        }
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function take($size = 1)
    {
        if (!is_int($size)) {
            throw new \InvalidArgumentException('Parameter n must be an integer');
        }

        return new static(new LazyTakeIterable($this, $size));
    }

    public function takeWhile(callable $callable)
    {
        return new static(new LazyTakeWhileIterable($this, $callable));
    }

    public function skip($n)
    {
        if (!is_int($n)) {
            throw new \InvalidArgumentException('Parameter n must be an integer');
        }

        return new static(new LazySkipIterable($this, $n));
    }

    public function skipWhile(callable $callable)
    {
        return new static(new LazySkipWhileIterable($this, $callable));
    }

    public function slice($start, $length)
    {
        if ($start < 0) {
            throw new \InvalidArgumentException('Parameter start must be a non-negative integer');
        }
        if ($length < 0) {
            throw new \InvalidArgumentException('Parameter len must be a non-negative integer');
        }

        return new static(new LazySliceIterable($this, $start, $length));
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function first()
    {
        if ($this->isEmpty()) {
            return null;
        }

        return current($this->container);
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function last()
    {
        if ($this->isEmpty()) {
            return null;
        }

        $lastItem = array_slice($this->container, -1, 1);

        return current($lastItem);
    }

    /**
     * {@inheritdoc}
     */
    public function exists(callable $fn)
    {
        foreach ($this as $element) {
            if ($fn($element)) {
                return true;
            }
        }

        return false;
    }

    public function concatAll()
    {
        /** @var VectorInterface $results */
        $results = new static();
        $this->each(function (Iterable $subArray) use ($results) {
            $subArray->each(function ($item) use ($results) {
                $results->add($item);
            });
        });

        return $results;
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function groupBy($callback)
    {
        $group = new Map();
        foreach ($this as $value) {
            $key = $callback($value);
            if (!$group->containsKey($key)) {
                $element = $this instanceof VectorInterface ? new static([$value]) : new Vector([$value]);
                $group->add(new Pair($key, $element));
            } else {
                $value = $group->get($key)->add($value);
                $group->set($key, $value);
            }
        }

        return $group;
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function indexBy($callback)
    {
        $group = new Map();
        foreach ($this as $value) {
            $key = $callback($value);
            $group->set($key, $value);
        }

        return $group;
    }

    /**
     * {@inheritdoc}
     */
    public function reduce(callable $callback, $initial = null)
    {
        foreach ($this as $element) {
            $initial = $callback($initial, $element);
        }

        return $initial;
    }
}
