<?php

namespace Collections\Traits;

use Collections\ArrayList;
use Collections\Dictionary;

trait StrictKeyedIterableTrait
{
    public function toArray()
    {
        $arr = [];
        foreach ($this as $key => $value) {
            if ($value instanceof \Iterable) {
                $arr[$key] = $value->toArray();
            } else {
                $arr[$key] = $value;
            }
        }

        return $arr;
    }

    public function values()
    {
        return new ArrayList($this);
    }

    public function keys()
    {
        $res = new ArrayList();
        foreach ($this as $k => $_) {
            $res[] = $k;
        }

        return $res;
    }

    public function map(callable $callback)
    {
        $res = new Dictionary();
        foreach ($this as $k => $v) {
            $res[$k] = $callback($v);
        }

        return $res;
    }

    public function mapWithKey($callback)
    {
        $res = new Dictionary();
        foreach ($this as $k => $v) {
            $res[$k] = $callback($k, $v);
        }

        return $res;
    }

    public function filter(callable $callback)
    {
        $res = new Dictionary();
        foreach ($this as $k => $v) {
            if ($callback($v)) {
                $res[$k] = $v;
            }
        }

        return $res;
    }

    public function filterWithKey($callback)
    {
        $res = new Dictionary();
        foreach ($this as $k => $v) {
            if ($callback($k, $v)) {
                $res[$k] = $v;
            }
        }

        return $res;
    }

    public function zip($iterable)
    {
        $res = new Dictionary();
        $it = $iterable->getIterator();
        foreach ($this as $k => $v) {
            if (!$it->valid()) {
                break;
            }
            $res[$k] = new Pair($v, $it->current());
            $it->next();
        }

        return $res;
    }

    public function take($size = 1)
    {
        $res = new Dictionary();
        if ($size <= 0) {
            return $res;
        }
        foreach ($this as $k => $v) {
            $res[$k] = $v;
            if (--$size === 0) {
                break;
            }
        }

        return $res;
    }

    public function takeWhile($fn)
    {
        $res = new Dictionary();
        foreach ($this as $k => $v) {
            if (!$fn($v)) {
                break;
            }
            $res[$k] = $v;
        }

        return $res;
    }

    public function skip($n)
    {
        $res = new Dictionary();
        foreach ($this as $k => $v) {
            if ($n <= 0) {
                $res[$k] = $v;
            } else {
                --$n;
            }
        }

        return $res;
    }

    public function skipWhile($fn)
    {
        $res = new Dictionary();
        $skip = true;
        foreach ($this as $k => $v) {
            if ($skip) {
                if ($fn($v)) {
                    continue;
                }
                $skip = false;
            }
            $res[$k] = $v;
        }

        return $res;
    }

    public function slice($start, $lenght)
    {
        $res = new Dictionary();
        if ($lenght <= 0) {
            return $res;
        }
        foreach ($this as $k => $v) {
            if ($start !== 0) {
                --$start;
                continue;
            }
            $res[$k] = $v;
            if (--$lenght === 0) {
                break;
            }
        }

        return $res;
    }

    public function concat(\Traversable $iterable)
    {
        $res = [];

        foreach ($this as $k => $v) {
            $res[$k] = $v;
        }

        foreach ($iterable as $k => $v) {
            $res[$k] = $v;
        }
        $this->container = $res;

        return $this;
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
        foreach ($this as $k => $v) {
            $callable($v, $k);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function every(callable $callable)
    {
        foreach ($this as $key => $value) {
            if (!$callable($value, $key)) {
                return false;
            }
        }

        return true;
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function some(callable $callable)
    {
        foreach ($this as $key => $value) {
            if ($callable($value, $key) === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * Iteratively reduce the collection to a single value using a callback function.
     *
     * @param callable $callable The callable used for reduce.
     * @param int $zero If the optional initial is available, it will be used at the beginning of the process,
     * or as a final result in case the array is empty.
     * @return $this A collection with the results of the filter operation.
     */
    public function reduce(callable $callable, $zero = null)
    {
        $isFirst = false;
        if (func_num_args() < 2) {
            $isFirst = true;
        }
        $result = $zero;
        foreach ($this as $k => $value) {
            if ($isFirst) {
                $result = $value;
                $isFirst = false;
                continue;
            }
            $result = $callable($result, $value, $k);
        }

        return $result;
    }
}
