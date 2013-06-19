<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

use Closure;
use Easy\Collections\Expr\ClosureExpressionVisitor;
use InvalidArgumentException;
use IteratorAggregate;

/**
 * Provides the abstract base class for a strongly typed collection.
 */
abstract class CollectionBase extends Enumerable implements CollectionInterface, SelectableInterface
{

    public function __construct($array = null)
    {
        if (is_array($array) || $array instanceof IteratorAggregate) {
            $this->addMultiple($array);
        }
    }

    /**
     * @{inheritdoc}
     */
    public function count()
    {
        return count($this->getArray());
    }

    /**
     * @{inheritdoc}
     */
    public function clear()
    {
        $this->array = array();
    }

    /**
     * @{inheritdoc}
     */
    public function contains($item)
    {
        return $this->itemExists($item, $this->array);
    }

    /**
     * @{inheritdoc}
     */
    public function IsEmpty()
    {
        return $this->count() < 1;
    }

    protected function addMultiple($items)
    {
        if (!is_array($items) && !($items instanceof IteratorAggregate)) {
            throw new InvalidArgumentException(__('Items must be either a Collection or an array'));
            return;
        }
        if ($items instanceof Enumerable) {
            $array = array_values($items->getArray());
        } else if (is_array($items)) {
            $array = $items;
        } else if ($items instanceof IteratorAggregate) {
            foreach ($items as $k => $v) {
                $array[$k] = $v;
            }
        }
        if (empty($array) == false) {
            $this->array = array_merge($this->array, $array);
        }
    }

    /**
     * @{inheritdoc}
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
     * @{inheritdoc}
     */
    public function filter(Closure $p)
    {
        return new static(array_filter($this->array, $p));
    }

    /**
     * @{inheritdoc}
     */
    public function forAll(Closure $p)
    {
        foreach ($this->array as $key => $element) {
            if (!$p($key, $element)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @{inheritdoc}
     */
    public function map(Closure $func)
    {
        return new static(array_map($func, $this->array));
    }

    /**
     * @{inheritdoc}
     */
    public function partition(Closure $p)
    {
        $coll1 = $coll2 = array();
        foreach ($this->array as $key => $element) {
            if ($p($key, $element)) {
                $coll1[$key] = $element;
            } else {
                $coll2[$key] = $element;
            }
        }
        return array(new static($coll1), new static($coll2));
    }

    /**
     * @{inheritdoc}
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

            usort($filtered, $next);
        }

        $offset = $criteria->getFirstResult();
        $length = $criteria->getMaxResults();

        if ($offset || $length) {
            $filtered = array_slice($filtered, (int) $offset, $length);
        }

        return new static($filtered);
    }

}