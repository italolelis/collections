<?php

namespace Collections\Traits;

use Collections\Iterable;
use Collections\ArrayList;
use Collections\Dictionary;
use Collections\VectorInterface;
use Easy\Generics\EquatableInterface;

trait CommonMutableContainerTrait
{
    /**
     * {@inheritdoc}
     */
    public function values()
    {
        return new ArrayList($this);
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
     * {@inheritDoc}
     * @return $this
     */
    public function groupBy($callback)
    {
        $group = new Dictionary();
        foreach ($this as $value) {
            $key = $callback($value);
            if (!$group->containsKey($key)) {
                $element = $this instanceof VectorInterface ? new static([$value]) : new ArrayList([$value]);
                $group->add($key, $element);
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
        $group = new Dictionary();
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

    /**
     * {@inheritdoc}
     */
    public function diff(Iterable $other, callable $callback = null)
    {
        if (null === $callback) {
            if ($this->first() instanceof EquatableInterface) {
                $this->container = array_udiff($this->container, $other->toArray(), function ($mine, $theirs) {
                    return $mine->equals($theirs);
                });

                return $this;
            }

            $this->container = array_diff($this->container, $other->toArray());

            return $this;
        }

        $this->container = array_udiff($this->container, $other->toArray(), $callback);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function intersect(Iterable $other, callable $callback = null)
    {
        if (null === $callback) {
            if ($this->first() instanceof EquatableInterface) {
                $this->container = array_uintersect($this->container, $other->toArray(), function ($mine, $theirs) {
                    return $mine->equals($theirs);
                });

                return $this;
            }

            $this->container = array_intersect($this->container, $other->toArray());

            return $this;
        }

        $this->container = array_uintersect($this->container, $other->toArray(), $callback);

        return $this;
    }
}
