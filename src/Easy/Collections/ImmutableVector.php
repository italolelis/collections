<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

use Closure;
use Easy\Collections\AbstractCollection;
use Easy\Collections\IConstIndexAccess;
use Easy\Collections\ImmutableVector;
use Easy\Collections\Linq\Criteria;
use Easy\Collections\Linq\Expr\ClosureExpressionVisitor;
use Easy\Generics\IEquatable;
use InvalidArgumentException;
use OutOfBoundsException;
use Traversable;

/**
 * Represents a strongly typed list of objects that can be accessed by index. Provides methods to search, sort, and manipulate lists.
 */
class ImmutableVector extends AbstractCollection implements IConstIndexAccess
{

    public function __construct($items = null)
    {
        if (!is_array($items) && !$items instanceof Traversable) {
            throw new InvalidArgumentException('The items must be an array or Traversable');
        }

        if ($items !== null) {
            $this->array = static::convertFromArray($items);
        }
    }

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
            throw new OutOfBoundsException(_('No element at position ') . $index);
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
     * {@inheritdoc}
     */
    public static function fromArray(array $arr)
    {
        return new ImmutableVector(static::convertFromArray($arr));
    }

    protected static function convertFromArray($arr)
    {
        $vector = array();
        foreach ($arr as $v) {
            if (is_array($v)) {
                $vector[] = new ImmutableVector($v);
            } else {
                $vector[] = $v;
            }
        }
        return $vector;
    }

    /**
     * {@inheritdoc}
     */
    public function filter(Closure $p)
    {
        return ImmutableVector::fromArray(array_filter($this->array, $p));
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

        return ImmutableVector::fromArray($filtered);
    }

}
