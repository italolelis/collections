<?php

namespace Collections\Iterator;

use Collections\Immutable\ImmVector;
use Collections\Immutable\ImmMap;
use Collections\Immutable\ImmSet;
use Collections\Map;
use Collections\Pair;
use Collections\Set;
use Collections\Vector;
use Collections\VectorInterface;

trait LazyIterableTrait
{
    public function toArray()
    {
        $arr = array();
        foreach ($this as $v) {
            $arr[] = $v;
        }

        return $arr;
    }

    public function toValuesArray()
    {
        return $this->toArray();
    }

    public function toVector()
    {
        return new Vector($this);
    }

    public function toImmVector()
    {
        return new ImmVector($this);
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

    public function map(callable $callback)
    {
        return new LazyMapIterable($this, $callback);
    }

    public function filter(callable $callback)
    {
        return new LazyFilterIterable($this, $callback);
    }

    public function zip($iterable)
    {
        if (is_array($iterable)) {
            $iterable = new ImmMap($iterable);
        }

        return new LazyZipIterable($this, $iterable);
    }

    public function take($size = 1)
    {
        return new LazyTakeIterable($this, $size);
    }

    public function takeWhile($fn)
    {
        return new LazyTakeWhileIterable($this, $fn);
    }

    public function skip($n)
    {
        return new LazySkipIterable($this, $n);
    }

    public function skipWhile($fn)
    {
        return new LazySkipWhileIterable($this, $fn);
    }

    public function slice($start, $len)
    {
        return new LazySliceIterable($this, $start, $len);
    }

    public function concat($iterable)
    {
        if (is_array($iterable)) {
            $iterable = new ImmMap($iterable);
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

    public function last()
    {
        $v = null;
        foreach ($this as $v) {
        }

        return $v;
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
