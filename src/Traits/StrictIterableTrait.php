<?php

namespace Collections\Traits;

trait StrictIterableTrait
{
    use CommonMutableContainerTrait;

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
}
