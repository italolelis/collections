<?php

namespace Collections\Traits;

trait StrictIterableTrait
{
    use ExtractTrait;

    public function toArray()
    {
        $arr = [];
        foreach ($this as $value) {
            if ($value instanceof \Iterable) {
                $arr[] = $value->toArray();
            } else {
                $arr[] = $value;
            }
        }

        return $arr;
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function map(callable $callable)
    {
        $res = new static();
        foreach ($this as $v) {
            $res[] = $callable($v);
        }

        return $res;
    }


    /**
     * {@inheritDoc}
     * @return $this
     */
    public function filter(callable $callable)
    {
        $res = new static();
        foreach ($this as $v) {
            if ($callable($v)) {
                $res[] = $v;
            }
        }

        return $res;
    }

    public function zip($iterable)
    {
        $res = new static();
        $it = $iterable->getIterator();
        foreach ($this as $v) {
            if (!$it->valid()) {
                break;
            }
            $res[] = new Pair($v, $it->current());
            $it->next();
        }

        return $res;
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function take($size = 1)
    {
        $res = new static();

        if ($size <= 0) {
            return $res;
        }

        foreach ($this as $v) {
            $res[] = $v;
            if (--$size === 0) {
                break;
            }
        }

        return $res;
    }

    public function takeWhile(callable $callable)
    {
        $res = new static();
        foreach ($this as $v) {
            if (!$callable($v)) {
                break;
            }
            $res[] = $v;
        }

        return $res;
    }

    public function skip($n)
    {
        $res = new static();
        foreach ($this as $v) {
            if ($n <= 0) {
                $res[] = $v;
            } else {
                --$n;
            }
        }

        return $res;
    }

    public function skipWhile(callable $callable)
    {
        $res = new static();
        $skip = true;
        foreach ($this as $v) {
            if ($skip) {
                if ($callable($v)) {
                    continue;
                }
                $skip = false;
            }
            $res[] = $v;
        }

        return $res;
    }

    public function slice($start, $length)
    {
        $res = new static();
        if ($length <= 0) {
            return $res;
        }
        foreach ($this as $v) {
            if ($start !== 0) {
                --$start;
                continue;
            }
            $res[] = $v;
            if (--$length === 0) {
                break;
            }
        }

        return $res;
    }

    public function concat(\Traversable $iterable)
    {
        $res = [];

        foreach ($this as $v) {
            $res[] = $v;
        }

        foreach ($iterable as $v) {
            $res[] = $v;
        }
        $this->container = $res;

        return $this;
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function first()
    {
        foreach ($this as $v) {
            return $v;
        }

        return null;
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function last()
    {
        $result = $this->toArray();

        return array_pop($result);
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
     * {@inheritDoc}
     * @return $this
     */
    public function every(callable $callable)
    {
        foreach ($this as $key => $value) {
            if (!$callable($value)) {
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
            if ($callable($value) === true) {
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
            $result = $callable($result, $value);
        }

        return $result;
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function match(array $conditions)
    {
        return $this->filter($this->createMatcherFilter($conditions));
    }
}
