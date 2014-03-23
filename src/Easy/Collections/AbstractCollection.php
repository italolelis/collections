<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

use ArrayIterator;
use Closure;
use Easy\Collections\Comparer\NumericKeyComparer;
use Easy\Collections\Generic\IComparer;
use Easy\Collections\Linq\Criteria;
use Easy\Collections\Linq\Expr\ClosureExpressionVisitor;
use Easy\Collections\Linq\IQueryable;
use Easy\Collections\Linq\ISelectable;
use Easy\Generics\IEquatable;
use InvalidArgumentException;

/**
 * Provides the abstract base class for a strongly typed collection.
 */
abstract class AbstractCollection implements ICollection, ICollectionConvertable, IQueryable, ISelectable, IEquatable
{

    protected $array = array();

    /**
     * @var IComparer
     */
    private $defaultComparer;

    public function getIterator()
    {
        return new ArrayIterator($this->array);
    }

    /**
     * Gets the default comparer for this collection
     * @return IComparer
     */
    public function getDefaultComparer()
    {
        if ($this->defaultComparer === null) {
            $this->defaultComparer = new NumericKeyComparer();
        }
        return $this->defaultComparer;
    }

    /**
     * Sets the default comparer for this collection
     * @param IComparer $defaultComparer
     * @return ArrayList
     */
    public function setDefaultComparer(IComparer $defaultComparer)
    {
        $this->defaultComparer = $defaultComparer;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->toArray());
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->array = array();
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty()
    {
        return $this->count() < 1;
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
    public function filter(Closure $p)
    {
        return static::getFromArray(array_filter($this->array, $p));
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
            $filtered = array_slice($filtered, (int) $offset, $length);
        }

        return static::getFromArray($filtered);
    }

    /**
     * {@inheritdoc}
     */
    public function values()
    {
        return array_values($this->array);
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize($this->array);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $this->array = unserialize($serialized);
        return $this->array;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return get_class($this);
    }

    public function equals($obj)
    {
        return ($obj === $this);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $array = array();
        foreach ($this->array as $key => $value) {
            if ($value instanceof ICollection) {
                $array[$key] = $value->toArray();
            } else {
                $array[$key] = $value;
            }
        }
        return $array;
    }

    /**
     * {@inheritdoc}
     */
    public function toKeysArrays()
    {
        return array_keys($this->array);
    }

}
