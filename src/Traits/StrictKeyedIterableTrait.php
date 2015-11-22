<?php

namespace Collections\Traits;

use Collections\ArrayList;
use Collections\Dictionary;
use Collections\Iterable;

trait StrictKeyedIterableTrait
{
    use CommonMutableContainerTrait;

    public function concatAll()
    {
        $results = new static();
        $this->each(function (Iterable $subArray) use ($results) {
            $subArray->each(function ($item, $key) use ($results) {
                $results->add($key, $item);
            });
        });

        return $results;
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
     * {@inheritdoc}
     */
    public function exists(callable $fn)
    {
        foreach ($this as $key => $element) {
            if ($fn($key, $element)) {
                return true;
            }
        }

        return false;
    }
}
