<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

use Easy\Collections\CollectionBase;
use Easy\Collections\Comparer\NumericKeyComparer;
use Easy\Collections\Generic\ComparerInterface;
use Easy\Generics\EquatableInterface;
use InvalidArgumentException;
use OutOfRangeException;

class Collection extends CollectionBase implements ListInterface
{

    private $defaultComparer;

    public function getDefaultComparer()
    {
        if ($this->defaultComparer === null) {
            $this->defaultComparer = new NumericKeyComparer();
        }
        return $this->defaultComparer;
    }

    public function setDefaultComparer($defaultComparer)
    {
        $this->defaultComparer = $defaultComparer;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function offsetExists($offset)
    {
        if (!is_numeric($offset)) {
            throw new InvalidArgumentException('The offset value must be numeric');
        }
        if ($offset < 0) {
            throw new InvalidArgumentException('The option value must be a number > 0');
        }
        return array_key_exists((int) $offset, $this->array);
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset)
    {
        return $this->elementAt($offset);
    }

    /**
     * @inheritdoc
     */
    public function offsetSet($offset, $value)
    {
        if (!is_numeric($offset)) {
            throw new InvalidArgumentException('The offset value must be numeric');
        }
        if ($offset < 0) {
            throw new InvalidArgumentException('The option value must be a number > 0');
        }
        $this->array[(int) $offset] = $value;
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset($offset)
    {
        $this->removeAt($offset);
    }

    /**
     * @inheritdoc
     */
    public function add($item)
    {
        array_push($this->array, $item);
    }

    /**
     * @inheritdoc
     */
    public function addRange($items)
    {
        $this->addMultiple($items);
    }

    /**
     * @inheritdoc
     */
    public function IndexOf($item, $start = null, $length = null)
    {
        return $this->getIndexOf($item, false, $start, $length);
    }

    /**
     * @inheritdoc
     */
    public function LastIndexOf($item, $start = null, $length = null)
    {
        return $this->getIndexOf($item, true, $start, $length);
    }

    /**
     * @inheritdoc
     */
    public function Insert($index, $item)
    {
        if (!is_numeric($index)) {
            throw new InvalidArgumentException('The index must be numeric');
        }
        if ($index < 0 || $index >= $this->Count()) {
            throw new InvalidArgumentException('The index is out of bounds (must be >=0 and <= size of te array)');
        }

        $current = $this->Count() - 1;
        for (; $current >= $index; $current--) {
            $this->array[$current + 1] = $this->array[$current];
        }
        $this->array[$index] = $item;
    }

    /**
     * @inheritdoc
     */
    public function remove($item)
    {
        if ($this->contains($item)) {
            $this->removeAt($this->getFirstIndex($item, $this->array));
        } else {
            throw new InvalidArgumentException('Item not found in the collection: <pre>' . var_export($item, true) . '</pre>');
        }
    }

    /**
     * @inheritdoc
     */
    public function removeAt($index)
    {
        if (!is_numeric($index)) {
            throw new InvalidArgumentException('The position must be numeric');
        }
        if ($index < 0 || $index >= $this->Count()) {
            throw new InvalidArgumentException('The index is out of bounds (must be >=0 and <= size of te array)');
        }

        $max = $this->Count() - 1;
        for (; $index < $max; $index++) {
            $this->array[$index] = $this->array[$index + 1];
        }
        array_pop($this->array);
    }

    /**
     * @inheritdoc
     */
    public function allIndexesOf($item)
    {
        return $this->getAllIndexes($item, $this->array);
    }

    /**
     * @inheritdoc
     */
    public function elementAt($index)
    {
        if ($this->offsetExists($index) === false) {
            throw new OutOfRangeException('No element at position ' . $index);
        }
        return $this->array[$index];
    }

    protected function getIndexOf($item, $lastIndex = false, $start = null, $length = null)
    {
        if ($start != null && !is_numeric($start)) {
            throw new InvalidArgumentException('The start value must be numeric or null');
            $start = null;
        }
        if ($length != null && !is_numeric($length)) {
            throw new InvalidArgumentException('The length value must be numeric or null');
            $length = null;
        }
        if ($start == null)
            $start = 0;
        if ($length == null)
            $length = count($this->array) - $start;
        $array = array_slice($this->array, $start, $length, true);

        if ($lastIndex == true)
            $array = array_reverse($array, true);
        $result = $this->getFirstIndex($item, $array);
        if ($result === false) {
            throw new InvalidArgumentException('Item not found in the collection: <pre>' . var_export($item, true) . '</pre>');
            return -1;
        }
        return $result;
    }

    protected function getAllIndexes($item, $array)
    {
        if (gettype($item) != 'object')
            $result = array_keys($array, $item, true);
        else {
            if ($item instanceof EquatableInterface) {
                $result = array();
                foreach ($array AS $k => $v) {
                    if ($item->equals($v)) {
                        $result[] = $k;
                    }
                }
            } else {
                $result = array_keys($array, $item, false);
            }
        }
        if (!is_array($result))
            $result = array();
        return $result;
    }

    protected function getFirstIndex($item, $array)
    {
        $result = false;
        if (gettype($item) != 'object')
            $result = array_search($item, $array, true);
        else {
            if ($item instanceof EquatableInterface) {
                foreach ($array AS $k => $v) {
                    if ($item->equals($v)) {
                        $result = $k;
                        break;
                    }
                }
            } else {
                $result = array_search($item, $array, false);
            }
        }
        return $result;
    }

    /**
     * Sorts the elements in the entire Collection<T> using the specified comparer.
     * @param ComparerInterface $comparer The ComparerInterface implementation to use when comparing elements, or null to use the default comparer Comparer<T>.Default.
     */
    public function sort(ComparerInterface $comparer = null)
    {
        if ($comparer === null) {
            $comparer = $this->getDefaultComparer();
        }
        usort($this->array, array($comparer, 'compare'));
    }

    /**
     * Sorts the keys in the entire Collection<T> using the specified comparer.
     * @param ComparerInterface $comparer The ComparerInterface implementation to use when comparing elements, or null to use the default comparer Comparer<T>.Default.
     */
    public function sortByKey(ComparerInterface $comparer = null)
    {
        if ($comparer === null) {
            $comparer = $this->getDefaultComparer();
        }
        ukort($this->array, array($comparer, 'compare'));
    }

}