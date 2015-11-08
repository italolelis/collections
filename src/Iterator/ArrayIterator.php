<?php

namespace Collections\Iterator;

class ArrayIterator extends IteratorCollectionAdapter
{
    public function __construct(array $array)
    {
        parent::__construct(new \ArrayIterator($array));
    }

    public function toArray()
    {
        $array = parent::toArray();
        foreach ($array as $key => $value) {
            if ($value instanceof \Iterable) {
                $array[$key] = $value->toArray();
            } else {
                $array[$key] = $value;
            }
        }

        return $array;
    }
}
