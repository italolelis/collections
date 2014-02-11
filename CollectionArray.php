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
use IteratorAggregate;

/**
 * Provides the abstract base class for a strongly typed collection.
 */
abstract class CollectionArray implements
IEnumerable, ICollection, IQueryable, ISelectable, IEquatable
{

    protected $array = array();

    /**
     * @var IComparer
     */
    private $defaultComparer;

    public function __construct($array = null)
    {
        if (is_array($array) || $array instanceof IteratorAggregate) {
            $this->addMultiple($array);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->array;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->array);
    }

    protected function itemExists($item, $array)
    {
        $result = false;
        if ($item instanceof EquatableInterface) {
            foreach ($array as $v) {
                if ($item->equals($v)) {
                    $result = true;
                    break;
                }
            }
        } elseif (in_array($item, $array, true)) {
            $result = in_array($item, $array);
        } else {
            $result = isset($array[$item]);
        }
        return $result;
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
     * @return List
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
    }

    /**
     * {@inheritdoc}
     */
    public function contains($item)
    {
        return $this->itemExists($item, $this->array);
    }

    /**
     * {@inheritdoc}
     */
    public function get($index)
    {
        if ($this->offsetExists($index) === false) {
            throw new OutOfBoundsException('No element at position ' . $index);
        }

        return $this->array[$index];
    }

    /**
     * {@inheritdoc}
     */
    public function tryGet($index, $default = null)
    {
        if ($this->offsetExists($index) === false) {
            return $default;
        }

        return $this->get($index);
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty()
    {
        return $this->count() < 1;
    }

    protected function addMultiple($items)
    {
        if (!is_array($items) && !($items instanceof IteratorAggregate)) {
            throw new InvalidArgumentException('Items must be either a Collection or an array');
        }
        if ($items instanceof Enumerable) {
            $array = array_values($items->toArray());
        } else if (is_array($items)) {
            $array = $items;
        } else if ($items instanceof IteratorAggregate) {
            foreach ($items as $k => $v) {
                $array[$k] = $v;
            }
        }
        if (empty($array) == false) {
            $this->array = $this->array + $array;
        }
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
        return new static(array_filter($this->array, $p));
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

            usort($filtered, $next);
        }

        $offset = $criteria->getFirstResult();
        $length = $criteria->getMaxResults();

        if ($offset || $length) {
            $filtered = array_slice($filtered, (int) $offset, $length);
        }

        return new static($filtered);
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
        ukort($this->array, array($comparer, 'compare'));
    }

    /**
     * {@inheritdoc}
     */
    public function remove($index)
    {
        if ($this->contains($index) == false) {
            throw new InvalidArgumentException('The key is not present in the dictionary');
        }
        unset($this->array[$index]);
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

}
