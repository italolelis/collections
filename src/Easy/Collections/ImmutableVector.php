<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

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
            foreach ($items as $item) {
                if (is_array($item)) {
                    $item = ImmutableVector::fromArray($item);
                }
                $this->array[] = $item;
            }
        }
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidElementsToInstanciate()
    {
        $coll = new \Easy\Collections\ImmutableVector('string');
    }

    /**
     * {@inheritdoc}
     */
    public function contains($item)
    {
        $result = false;
        $array = $this->array;
        if ($item instanceof IEquatable) {
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
     * {@inheritdoc}
     */
    public function get($index)
    {
        if ($this->contains($index) === false) {
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
        if ($this->contains($index) === false) {
            return $default;
        }

        return $this->get($index);
    }

    public static function getFromArray($arr)
    {
        return ImmutableVector::fromArray($arr);
    }

    /**
     * {@inheritdoc}
     */
    public static function fromArray(array $arr)
    {
        $vector = array();
        foreach ($arr as $v) {
            if (is_array($v)) {
                $vector[] = new ImmutableVector($v);
            } else {
                $vector[] = $v;
            }
        }
        return new ImmutableVector($vector);
    }

}
