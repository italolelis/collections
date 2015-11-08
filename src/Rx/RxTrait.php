<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections\Rx;

use CallbackFilterIterator;
use Collections\ArrayList;
use Collections\CollectionInterface;
use Collections\Dictionary;
use Collections\ExtractTrait;
use Collections\Iterator\ExtractIterator;
use Collections\Iterator\InsertIterator;
use Collections\Iterator\ReplaceIterator;
use LimitIterator;

trait RxTrait
{
    use ExtractTrait;

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function each(callable $callable)
    {
        foreach ($this->getIterator() as $k => $v) {
            $callable($v, $k);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function map(callable $callable)
    {
        return $this->iteratorToCollection(new ReplaceIterator($this->getIterator(), $callable));
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function filter(callable $callable)
    {
        return $this->iteratorToCollection(new CallbackFilterIterator($this->getIterator(), $callable));
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function take($size = 1, $from = 0)
    {
        return $this->iteratorToCollection(new LimitIterator($this->getIterator(), $from, $size));
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function slice($start, $length = null)
    {
        return $this->iteratorToCollection(array_slice($this->getIterator(), $start, $length));
    }

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
     * {@inheritDoc}
     * @return $this
     */
    public function every(callable $callable)
    {
        foreach ($this->getIterator() as $key => $value) {
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
        foreach ($this->getIterator() as $key => $value) {
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
        foreach ($this->getIterator() as $k => $value) {
            if ($isFirst) {
                $result = $value;
                $isFirst = false;
                continue;
            }
            $result = $callable($result, $value, $k);
        }

        return $result;
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
    public function sample($size = 10)
    {
        return $this->iteratorToCollection(new LimitIterator($this->shuffle()->getIterator(), 0, $size));
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
