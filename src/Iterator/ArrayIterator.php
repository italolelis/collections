<?php

namespace Collections\Iterator;

use Collections\CollectionConvertableInterface;

class ArrayIterator extends IteratorCollectionAdapter
{
    private $count;

    public function __construct(array $array)
    {
        parent::__construct(new \ArrayIterator($array));
        $this->count = count($array);
    }
    
    public function toArray()
    {
        $array = parent::toArray();
        foreach ($array as $key => $value) {
            if ($value instanceof CollectionConvertableInterface) {
                $array[$key] = $value->toArray();
            } else {
                $array[$key] = $value;
            }
        }

        return $array;
    }
}
