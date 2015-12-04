<?php

namespace Collections\Traits;

use Collections\ArrayList;
use Collections\Dictionary;
use Collections\Iterable;
use Collections\VectorInterface;

trait CommonMutableContainerTrait
{
    use ExtractTrait;

    /**
     * @return ArrayList
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
        return $this->toArray();
    }

    /**
     * @return array
     */
    public function toKeysArray()
    {
        $results = [];
        /** @var Dictionary $this */
        foreach ($this as $key => $nulled) {
            $results[] = $key;
        }

        return $results;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $results = [];
        /** @var Dictionary $this */
        foreach ($this as $key => $element) {
            if ($element instanceof Iterable) {
                $results[$key] = $element->toArray();
            } else {
                $results[$key] = $element;
            }
        }

        return $results;
    }

    /**
     * @param array $array
     *
     * @return CommonMutableContainerTrait
     */
    public static function fromArray(array $array)
    {
        $map = new static();
        foreach ($array as $key => $element) {
            if (is_array($element)) {
                $map[$key] = new static($element);
            } else {
                $map[$key] = $element;
            }
        }

        return $map;
    }

    /**
     * {@inheritDoc}
     * @return Dictionary
     */
    public function groupBy($callback)
    {
        $callback = $this->propertyExtractor($callback);
        $group = new Dictionary();
        /** @var Dictionary $this */
        foreach ($this as $element) {
            $key = $callback($element);
            if (!$group->containsKey($key)) {
                $element = ($this instanceof VectorInterface) ? new static([$element]) : new ArrayList([$element]);
                $group->add($key, $element);
            } else {
                $element = $group->get($key)->add($element);
                $group->set($key, $element);
            }
        }

        return $group;
    }

    /**
     * {@inheritDoc}
     * @return Dictionary
     */
    public function indexBy($callback)
    {
        $callback = $this->propertyExtractor($callback);
        $group = new Dictionary();
        /** @var Dictionary $this */
        foreach ($this as $element) {
            $key = $callback($element);
            $group->set($key, $element);
        }

        return $group;
    }
}
