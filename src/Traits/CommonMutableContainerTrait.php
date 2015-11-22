<?php

namespace Collections\Traits;

use Collections\ArrayList;
use Collections\Dictionary;
use Collections\Iterable;

trait CommonMutableContainerTrait
{
    use ExtractTrait;

    /**
     * {@inheritdoc}
     */
    public function values()
    {
        return new ArrayList($this);
    }

    public function toValuesArray()
    {
        return $this->toArray();
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
        $callback = $this->propertyExtractor($callback);
        $group = new Dictionary();
        foreach ($this as $value) {
            $key = $callback($value);
            if (!$group->containsKey($key)) {
                $group->add($key, new ArrayList([$value]));
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
        $callback = $this->propertyExtractor($callback);
        $group = new Dictionary();
        foreach ($this as $value) {
            $key = $callback($value);
            $group->set($key, $value);
        }

        return $group;
    }
}
