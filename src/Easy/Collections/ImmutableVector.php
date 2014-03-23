<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

use Easy\Generics\IEquatable;
use OutOfBoundsException;

/**
 * Represents a strongly typed list of objects that can be accessed by index. Provides methods to search, sort, and manipulate lists.
 */
class ImmutableVector extends AbstractCollection implements IConstIndexAccess
{

    public function __construct(Traversable $items = null)
    {
        if ($items !== null) {
            foreach ($items as $item) {
                if (is_array($item)) {
                    $item = ImmutableVector::fromArray($item);
                }
                $this->add($item);
            }
        }
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

}
