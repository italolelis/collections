<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Easy\Collections;

use Closure;
use Easy\Collections\Generic\ComparerInterface;
use Easy\Collections\Linq\Criteria;
use Easy\Collections\Linq\Expr\ClosureExpressionVisitor;
use Easy\Collections\Linq\SelectableInterface;
use Easy\Collections\Rx\ReactiveExtensionInterface;
use InvalidArgumentException;

/**
 * Provides the abstract base class for a strongly typed collection.
 */
abstract class CollectionArray extends AbstractCollection implements
    IndexAccessInterface, ConstIndexAccessInterface, ReactiveExtensionInterface, SelectableInterface, CollectionConvertableInterface
{

    /**
     * {@inheritdoc}
     */
    public function containsKey($key)
    {
        return $this->offsetExists($key);
    }

    /**
     * {@inheritdoc}
     */
    public function contains($element)
    {
        return in_array($element, $this->array, true);
    }

    /**
     * {@inheritdoc}
     */
    public function get($index)
    {
        return $this->offsetGet($index);
    }

    /**
     * {@inheritdoc}
     * @param string $default
     */
    public function tryGet($index, $default = null)
    {
        if ($this->containsKey($index) === false) {
            return $default;
        }

        return $this->get($index);
    }

    /**
     * Sorts the elements in the entire Collection<T> using the specified comparer.
     * @param ComparerInterface $comparer The ComparerInterface implementation to use when comparing elements, or null to use the default comparer Comparer<T>.Default.
     * @return $this
     */
    public function sort(ComparerInterface $comparer = null)
    {
        if ($comparer === null) {
            $comparer = $this->getDefaultComparer();
        }
        usort($this->array, array($comparer, 'compare'));
        return $this;
    }

    /**
     * Sorts the keys in the entire Collection<T> using the specified comparer.
     * @param ComparerInterface $comparer The ComparerInterface implementation to use when comparing elements, or null to use the default comparer Comparer<T>.Default.
     * @return $this
     */
    public function sortByKey(ComparerInterface $comparer = null)
    {
        if ($comparer === null) {
            $comparer = $this->getDefaultComparer();
        }
        uksort($this->array, array($comparer, 'compare'));
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($index)
    {
        $this->offsetUnset($index);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeValue($element)
    {
        $key = array_search($element, $this->array, true);

        if ($key !== false) {
            $this->offsetUnset($key);
            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function exists(Closure $p)
    {
        foreach ($this->array as $key => $element) {
            if ($p($key, $element)) {
                return true;
            }
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function map($p)
    {
        if (!is_callable($p)) {
            throw new InvalidArgumentException('The parameter must be a callable');
        }

        return static::fromArray(array_map($p, $this->array, array_keys($this->array)));
    }

    /**
     * Returns all the elements of this collection that satisfy the predicate p.
     * The order of the elements is preserved.
     *
     * @param callable $p The predicate used for map.
     *
     * @return CollectionInterface A collection with the results of the filter operation.
     */
    public function flatMap($p)
    {
        $collection = call_user_func_array(array($this, "map"), array($p));

        $flattenData = iterator_to_array(new \RecursiveIteratorIterator(
            new \RecursiveArrayIterator($collection->toArray())), false);

        return static::fromArray($flattenData);
    }


    /**
     * {@inheritdoc}
     */
    public function filter(Closure $p)
    {
        return static::fromArray(array_filter($this->array, $p));
    }

    /**
     * Iteratively reduce the collection to a single value using a callback function.
     *
     * @param callable $p The predicate used for reduce.
     * @param int $initial If the optional initial is available, it will be used at the beginning of the process, or as a final result in case the array is empty.
     * @return CollectionInterface A collection with the results of the filter operation.
     */
    public function reduce($p, $initial = null)
    {
        return static::fromArray(array_reduce($this->array, $p, $initial));
    }


    /**
     * Returns the first element of an observable sequence that satisfies the condition in the predicate if present else the first item in the sequence.
     *
     * @return CollectionInterface A collection with the results of the filter operation.
     */
    public function first()
    {
        return array_shift($this->array);
    }

    /**
     * Returns the last element of an observable sequence that satisfies the condition in the predicate if specified, else the last element.
     *
     * @return CollectionInterface A collection with the results of the filter operation.
     */
    public function last()
    {
        return array_pop($this->array);
    }

    /**
     * Returns a specified number of contiguous elements from the start of an observable sequence, using the specified scheduler for the edge case of take(0).
     *
     * @param integer $count The number of elements to take.
     *
     * @return CollectionInterface A collection with the results of the filter operation.
     */
    public function take($count)
    {
        return $this->slice(0, $count);
    }

    /**
     * {@inheritdoc}
     * @deprecated
     */
    public function slice($offset, $length = null)
    {
        return ArrayList::fromArray(array_slice($this->array, $offset, $length));
    }

    /**
     * {@inheritdoc}
     */
    public function matching(Criteria $criteria)
    {
        $expr = $criteria->getWhereExpression();
        $filtered = $this->array;

        if ($expr) {
            $visitor = new ClosureExpressionVisitor();
            $filter = $visitor->dispatch($expr);
            $filtered = array_filter($filtered, $filter);
        }

        $orderings = $criteria->getOrderings();
        if ($orderings) {
            $next = null;
            foreach (array_reverse($orderings) as $field => $ordering) {
                $next = ClosureExpressionVisitor::sortByField($field, $ordering == 'DESC' ? -1 : 1, $next);
            }

            if ($next === null) {
                throw new InvalidArgumentException("The next value needs to be a callable function");
            }

            usort($filtered, $next);
        }

        $offset = $criteria->getFirstResult();
        $length = $criteria->getMaxResults();

        if ($offset || $length) {
            $filtered = array_slice($filtered, (int)$offset, $length);
        }

        return static::fromArray($filtered);
    }
}
