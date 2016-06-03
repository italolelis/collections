<?php

namespace Collections\Traits;

use Collections\ArrayList;
use Collections\Iterable;
use Collections\MapInterface;

trait StrictKeyedIterableTrait
{
    use CommonMutableContainerTrait;

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
        $res = new static();
        foreach ($this as $k => $v) {
            $res[$k] = $callback($v);
        }

        return $res;
    }

    public function mapWithKey($callback)
    {
        $res = new static();
        foreach ($this as $k => $v) {
            $res[$k] = $callback($k, $v);
        }

        return $res;
    }

    public function filter(callable $callback)
    {
        $res = new static();
        foreach ($this as $k => $v) {
            if ($callback($v)) {
                $res[$k] = $v;
            }
        }

        return $res;
    }

    public function filterWithKey($callback)
    {
        $res = new static();
        foreach ($this as $k => $v) {
            if ($callback($k, $v)) {
                $res[$k] = $v;
            }
        }

        return $res;
    }

    public function zip($iterable)
    {
        $res = new static();
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
        $res = new static();
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
        $res = new static();
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
        $res = new static();
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
        $res = new static();
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
        $res = new static();
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

    public function concatAll()
    {
        /** @var MapInterface $results */
        $results = new static();
        $this->each(function (Iterable $subArray) use ($results) {
            $subArray->each(function ($item, $key) use ($results) {
                $results->add($key, $item);
            });
        });

        return $results;
    }

    private function concatRecurse($array, $array1)
    {
        $merged = $array;

        foreach ($array1 as $key => $value) {
            $isValid = function ($value) {
                return (is_array($value) || $value instanceof \Traversable);
            };

            if (($isValid($value) && isset($merged[$key])) && $isValid($merged[$key])) {
                $merged[$key] = $this->concatRecurse($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }

        return $merged;
    }
}
