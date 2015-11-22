<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

use SplQueue;

/**
 * Represents a first-in, first-out collection of objects.
 */
class Queue extends SplQueue implements QueueInterface, \JsonSerializable
{

    /**
     * Adds multiples objects to the end of the Queue.
     * @param CollectionInterface|array $items The objects to add to the Queue. The value can be null.
     * @return $this|Queue
     */
    public function enqueueMultiple($items)
    {
        foreach ($items as $item) {
            $this->enqueue($item);
        }

        return $this;
    }

    public static function fromArray(array $arr)
    {
        $collection = new Queue();
        foreach ($arr as $v) {
            if (is_array($v)) {
                $collection->enqueue(static::fromArray($v));
            } else {
                $collection->enqueue($v);
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
