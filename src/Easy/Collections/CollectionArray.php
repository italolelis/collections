<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Easy\Collections;

use Closure;
use Easy\Collections\Generic\IComparer;
use Easy\Collections\Linq\Criteria;
use Easy\Collections\Linq\Expr\ClosureExpressionVisitor;
use Easy\Collections\Linq\IQueryable;
use Easy\Collections\Linq\ISelectable;
use InvalidArgumentException;
use OutOfBoundsException;
use Traversable;

/**
 * Provides the abstract base class for a strongly typed collection.
 */
abstract class CollectionArray extends AbstractCollection
    implements IIndexAccess, IConstIndexAccess, IQueryable, ISelectable, ICollectionConvertable
{

    /**
     * {@inheritdoc}
     */
    public function containsKey($key)
    {
        return isset($this->array[$key]) || array_key_exists($key, $this->array);
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
        if ($this->containsKey($index) === false) {
            throw new OutOfBoundsException('No element at position ' . $index);
        }

        return $this->array[$index];
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
     * @param IComparer $comparer The ComparerInterface implementation to use when comparing elements, or null to use the default comparer Comparer<T>.Default.
     */
    public function sort(IComparer $comparer = null)
    {
        if ($comparer === null) {
            $comparer = $this->getDefaultComparer();
        }
        usort($this->array, array($comparer, 'compare'));
        return $this;
    }

    /**
     * Sorts the keys in the entire Collection<T> using the specified comparer.
     * @param IComparer $comparer The ComparerInterface implementation to use when comparing elements, or null to use the default comparer Comparer<T>.Default.
     */
    public function sortByKey(IComparer $comparer = null)
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
        if ($this->containsKey($index) == false) {
            throw new InvalidArgumentException('The key ' . $index . ' is not present in the dictionary');
        }
        unset($this->array[$index]);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeValue($element)
    {
        $key = array_search($element, $this->array, true);

        if ($key !== false) {
            unset($this->array[$key]);
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

        return static::fromArray(array_map($p, $this->array));
    }

    /**
     * {@inheritdoc}
     */
    public function filter(Closure $p)
    {
        return static::fromArray(array_filter($this->array, $p));
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

        if ($orderings = $criteria->getOrderings()) {
            $next = null;
            foreach (array_reverse($orderings) as $field => $ordering) {
                $next = ClosureExpressionVisitor::sortByField($field,
                                                              $ordering == 'DESC' ? -1 : 1,
                                                              $next);
            }

            if ($next === null) {
                throw new InvalidArgumentException("The next value needs to be a callable function");
            }

            usort($filtered, $next);
        }

        $offset = $criteria->getFirstResult();
        $length = $criteria->getMaxResults();

        if ($offset || $length) {
            $filtered = array_slice($filtered, (int) $offset, $length);
        }

        return static::fromArray($filtered);
    }
}