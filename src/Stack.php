<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

use Collections\Iterator\LinkedStackIterator;
use SplStack;

/**
 * Represents a simple last-in-first-out (LIFO) non-generic collection of objects.
 */
class Stack extends SplStack implements StackInterface, \JsonSerializable
{
    /**
     * Inserts multiples objects at the top of the Stack.
     * @param array $items The Objects to push onto the Stack. The value <b>can</b> be null.
     * @return $this|Stack
     */
    public function pushMultiple($items)
    {
        foreach ($items as $item) {
            $this->push($item);
        }

        return $this;
    }

    public static function fromArray(array $arr)
    {
        $collection = new Stack();
        foreach ($arr as $v) {
            if (is_array($v)) {
                $collection->push(static::fromArray($v));
            } else {
                $collection->push($v);
            }
        }

        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $array = array();
        foreach ($this as $key => $value) {
            if ($value instanceof CollectionConvertableInterface) {
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
    public function __toString()
    {
        return get_class($this);
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
//        return $this->getIterator()->toArray();
    }
}
