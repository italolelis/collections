<?php

namespace Collections\Iterator;

use Collections\Vector;
use Collections\Dictionary;
use Collections\Immutable\ImmArrayList;
use Collections\Immutable\ImmDictionary;
use Collections\Immutable\ImmSet;
use Collections\Set;

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
        return new Dictionary($this);
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

    public function zip($iterable)
    {
        if (is_array($iterable)) {
            $iterable = new ImmDictionary($iterable);
        }

        return new LazyZipKeyedIterable($this, $iterable);
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

    public function each(callable $callable)
    {
        foreach ($this as $k => $v) {
            $callable($v, $k);
        }

        return $this;
    }
}