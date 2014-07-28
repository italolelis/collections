<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Easy\Collections;

use Easy\Collections\AbstractCollection;
use Easy\Collections\IConstIndexAccess;
use Easy\Collections\ImmutableVector;
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
}