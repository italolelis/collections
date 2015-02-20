<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections\Rx;

use CallbackFilterIterator;
use Collections\CollectionInterface;
use Collections\ExtractTrait;
use Collections\Iterator\ExtractIterator;
use Collections\Iterator\InsertIterator;
use Collections\Iterator\ReplaceIterator;
use Collections\Iterator\UnfoldIterator;
use LimitIterator;
use RecursiveIteratorIterator;

trait RxTrait
{

    use ExtractTrait;

    /**
     * {@inheritDoc}
     *
     */
    public function each(callable $c)
    {
        foreach ($this->getIterator() as $k => $v) {
            $c($v, $k);
        }
        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @return CollectionInterface
     */
    public function filter(callable $c)
    {
        return $this->iteratorToCollection(new CallbackFilterIterator($this->getIterator(), $c));
    }

    /**
     * {@inheritDoc}
     *
     * @return CollectionInterface
     */
    public function map(callable $c)
    {
        return $this->iteratorToCollection(new ReplaceIterator($this->getIterator(), $c));
    }

    /**
     * {@inheritDoc}
     *
     * @return CollectionInterface
     */
    public function reject(callable $c)
    {
        return $this->iteratorToCollection(new CallbackFilterIterator($this->getIterator(),
            function ($key, $value, $items) use ($c) {
                return !$c($key, $value, $items);
            }));
    }

    /**
     * {@inheritDoc}
     *
     */
    public function every(callable $c)
    {
        foreach ($this->getIterator() as $key => $value) {
            if (!$c($value, $key)) {
                return false;
            }
        }
        return true;
    }

    /**
     * {@inheritDoc}
     *
     */
    public function some(callable $c)
    {
        foreach ($this->getIterator() as $key => $value) {
            if ($c($value, $key) === true) {
                return true;
            }
        }
        return false;
    }

    /**
     * Iteratively reduce the collection to a single value using a callback function.
     *
     * @param callable $c The callable used for reduce.
     * @param int $zero If the optional initial is available, it will be used at the beginning of the process,
     * or as a final result in case the array is empty.
     * @return CollectionInterface A collection with the results of the filter operation.
     */
    public function reduce(callable $c, $zero = null)
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
            $result = $c($result, $value, $k);
        }
        return $result;
    }

    /**
     * @param $matcher
     * @return CollectionInterface
     */
    public function extract($matcher)
    {
        return $this->iteratorToCollection(new ExtractIterator($this, $matcher));
    }

    /**
     * {@inheritDoc}
     *
     */
    public function sample($size = 10)
    {
        return $this->iteratorToCollection(new LimitIterator($this->shuffle()->getIterator(), 0, $size));
    }

    /**
     * {@inheritDoc}
     *
     */
    public function take($size = 1, $from = 0)
    {
        return $this->iteratorToCollection(new LimitIterator($this->getIterator(), $from, $size));
    }

    /**
     * {@inheritDoc}
     *
     */
    public function match(array $conditions)
    {
        return $this->filter($this->createMatcherFilter($conditions));
    }

    /**
     * {@inheritDoc}
     *
     */
    public function firstMatch(array $conditions)
    {
        return $this->match($conditions)->first();
    }

    /**
     * {@inheritDoc}
     */
    public function insert($path, $values)
    {
        return new InsertIterator($this->getIterator(), $path, $values);
    }

    /**
     * {@inheritDoc}
     *
     */
    public function first()
    {
        foreach ($this->take(1) as $result) {
            return $result;
        }
    }

    /**
     * Returns the last element of an observable sequence that satisfies the condition in the predicate if specified,
     * else the last element.
     *
     * @return CollectionInterface A collection with the results of the filter operation.
     */
    public function last()
    {
        return array_pop($this->getIterator());
    }

    /**
     * {@inheritDoc}
     *
     */
    public function unfold(callable $transformer = null)
    {
        if ($transformer === null) {
            $transformer = function ($item) {
                return $item;
            };
        }
        return $this->iteratorToCollection(
            new RecursiveIteratorIterator(
                new UnfoldIterator($this->getIterator(), $transformer),
                RecursiveIteratorIterator::LEAVES_ONLY
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function shuffle()
    {
        shuffle($this->storage);
        return $this;
    }

    /**
     * @param $iterator
     * @param bool $useKeys
     * @return CollectionInterface
     */
    protected function iteratorToCollection($iterator, $useKeys = true)
    {
        return static::fromArray(iterator_to_array($iterator), $useKeys);
    }
}
