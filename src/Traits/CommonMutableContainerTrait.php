<?php

namespace Collections\Traits;

use Collections\ArrayList;
use Collections\Dictionary;
use Collections\Iterable;
use Collections\VectorInterface;

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
     * {@inheritDoc}
     * @return $this
     */
    public function concat($iterable)
    {
        if (!is_array($iterable) && !$iterable instanceof \Traversable) {
            throw new \InvalidArgumentException('The items must be an array or Traversable');
        }

        $this->setAll($this->concatRecurse($this, $iterable));

        return $this;
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function replace($iterable)
    {
        if (!is_array($iterable) && !$iterable instanceof \Traversable) {
            throw new \InvalidArgumentException('The items must be an array or Traversable');
        }

        $this->setAll($this->concatRecurse($this, $iterable));

        return $this;
    }

    private function concatRecurse($array, $array1)
    {
        $merged = $array;

        foreach ($array1 as $key => & $value) {
            $isValid = function ($value) {
                return (is_array($value) || $value instanceof \Traversable);
            };

            if (($isValid($value) && isset($merged[$key])) && $isValid($merged[$key])) {
                $merged[$key] = $this->concatRecurse($merged[$key], $value);
            } else {
                if (is_numeric($key)) {
                    if (!isset($merged[$value])) {
                        $merged[] = $value;
                    }
                } else {
                    $merged[$key] = $value;
                }
            }
        }

        return $merged;
    }

    private function replaceRecurse($array, $array1)
    {
        foreach ($array1 as $key => $value) {
            // create new key in $array, if it is empty or not an array
            if (!isset($array[$key]) || (isset($array[$key]) && (!is_array($array[$key]) && !$array[$key] instanceof \Traversable))) {
                $array[$key] = [];
            }

            // overwrite the value in the base array
            if (is_array($value) || $value instanceof \Traversable) {
                $value = $this->replaceRecurse($array[$key], $value);
            }
            $array[$key] = $value;
        }

        return $array;
    }
}
