<?php

namespace Collections\Iterator;

use Collections\ArrayList;
use Collections\Immutable\ImmArrayList;
use Collections\Immutable\ImmDictionary;
use Collections\Immutable\ImmSet;
use Collections\Set;

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
        return new ArrayList($this);
    }

    public function toImmVector()
    {
        return new ImmArrayList($this);
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
            $iterable = new ImmDictionary($iterable);
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

    public function last()
    {
        $v = null;
        foreach ($this as $v) {
        }

        return $v;
    }

    public function each(callable $callable)
    {
        foreach ($this as $k => $v) {
            $callable($v, $k);
        }

        return $this;
    }
}
