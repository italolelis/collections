<?php

namespace Collections\Iterator;

use Collections\Immutable\ImmArrayList;
use Collections\Immutable\ImmDictionary;
use Collections\Immutable\ImmSet;
use Collections\Map;
use Collections\Pair;
use Collections\Set;
use Collections\Vector;
use Collections\VectorInterface;

trait LazyKeyedIterableTrait
{
    public function toArray()
    {
        $arr = [];
        foreach ($this as $k => $v) {
            $arr[$k] = $v;
        }

        return $arr;
    }

    public function toValuesArray()
    {
        $arr = [];
        foreach ($this as $v) {
            $arr[] = $v;
        }

        return $arr;
    }

    public function toKeysArray()
    {
        $arr = [];
        foreach ($this as $k => $_) {
            $arr[] = $k;
        }

        return $arr;
    }

    public function toVector()
    {
        return new Vector($this);
    }

    public function toImmVector()
    {
        return new ImmArrayList($this);
    }

    public function toMap()
    {
        return new Map($this);
    }

    public function toImmMap()
    {
        return new ImmDictionary($this);
    }

    public function toSet()
    {
        return new Set($this);
    }

    public function toImmSet()
    {
        return new ImmSet($this);
    }

    public function lazy()
    {
        return $this;
    }

    public function values()
    {
        return new LazyValuesIterable($this);
    }

    public function keys()
    {
        return new LazyKeysIterable($this);
    }

    public function map($callback)
    {
        return new LazyMapKeyedIterable($this, $callback);
    }

    public function mapWithKey($callback)
    {
        return new LazyMapWithKeyIterable($this, $callback);
    }

    public function filter($callback)
    {
        return new LazyFilterKeyedIterable($this, $callback);
    }

    public function filterWithKey($callback)
    {
        return new LazyFilterWithKeyIterable($this, $callback);
    }

    public function zip($traversable)
    {
        if (is_array($traversable)) {
            $traversable = new ImmDictionary($traversable);
        }

        return new LazyZipKeyedIterable($this, $traversable);
    }

    public function take($n)
    {
        return new LazyTakeKeyedIterable($this, $n);
    }

    public function takeWhile($fn)
    {
        return new LazyTakeWhileKeyedIterable($this, $fn);
    }

    public function skip($n)
    {
        return new LazySkipKeyedIterable($this, $n);
    }

    public function skipWhile($fn)
    {
        return new LazySkipWhileKeyedIterable($this, $fn);
    }

    public function slice($start, $len)
    {
        return new LazySliceKeyedIterable($this, $start, $len);
    }

    public function concat($iterable)
    {
        if (is_array($iterable)) {
            $iterable = new ImmDictionary($iterable);
        }

        return new LazyConcatIterable($this, $iterable);
    }

    public function first()
    {
        foreach ($this as $v) {
            return $v;
        }

        return null;
    }

    public function firstKey()
    {
        foreach ($this as $k => $_) {
            return $k;
        }

        return null;
    }

    public function last()
    {
        $v = null;
        foreach ($this as $v) {
        }

        return $v;
    }

    public function lastKey()
    {
        $k = null;
        foreach ($this as $k => $_) {
        }

        return $k;
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
        $this->each(function ($subArray) use ($results) {
            foreach ($subArray as $item) {
                $results->add($item);
            }
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