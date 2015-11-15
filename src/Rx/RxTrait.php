<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections\Rx;

use CallbackFilterIterator;
use Collections\ArrayList;
use Collections\Dictionary;
use Collections\Iterator\ExtractIterator;
use Collections\Iterator\InsertIterator;
use Collections\Traits\ExtractTrait;

trait RxTrait
{
    use ExtractTrait;

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function reject(callable $callable)
    {
        $filterCallback = function ($key, $value, $items) use ($callable) {
            return !$callable($key, $value, $items);
        };

        return $this->iteratorToCollection(new CallbackFilterIterator($this->getIterator(), $filterCallback));
    }

    /**
     * @param $matcher
     * @return $this
     */
    public function extract($matcher)
    {
        return $this->iteratorToCollection(new ExtractIterator($this, $matcher));
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function match(array $conditions)
    {
        return $this->filter($this->createMatcherFilter($conditions));
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function firstMatch(array $conditions)
    {
        return $this->match($conditions)->first();
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function insert($path, $values)
    {
        return new InsertIterator($this->getIterator(), $path, $values);
    }

    /**
     * {@inheritdoc}
     * @return $this
     */
    public function shuffle()
    {
        shuffle($this->storage);

        return $this;
    }

    /**
     * @param $iterator
     * @return $this
     */
    protected function iteratorToCollection($iterator)
    {
        return new static($iterator);
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
