<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

use InvalidArgumentException;

/**
 * Represents a collection of keys and values.
 */
class RecursiveDictionary extends Dictionary
{

    protected function addMultiple($items)
    {
        if (!is_array($items) && !($items instanceof IteratorAggregate)) {
            throw new InvalidArgumentException('Items must be either a Collection or an array');
        }
        if ($items instanceof Enumerable) {
            $array = array_values($items->toArray());
        } else if (is_array($items)) {
            foreach ($items as $k => $v) {
                if (is_array($v)) {
                    $array[$k] = new RecursiveDictionary($v);
                } else {
                    $array[$k] = $v;
                }
            }
        } else if ($items instanceof IteratorAggregate) {
            foreach ($items as $k => $v) {
                $array[$k] = new RecursiveDictionary($v);
            }
        }
        if (empty($array) == false) {
            $this->array = $this->array + $array;
        }
    }

    public function toArray()
    {
        $array = array();
        foreach ($this->array as $k => $v) {
            if ($v instanceof IDictionary) {
                $array[$k] = $v->toArray();
            } else {
                $array[$k] = $v;
            }
        }
        return $array;
    }

}
