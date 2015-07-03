<?php

namespace Collections\Iterator;

use Collections\CollectionConvertableInterface;
use Collections\Pair;

class HashMapIterator extends IteratorCollectionAdapter implements MapIteratorInterface
{

    private $size = 0;


    public function __construct(array $storage)
    {
        parent::__construct(new \ArrayIterator($storage));
        $this->size = count($storage);
    }


    /**
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed
     */
    public function key()
    {
        /**
         * @var Pair $pair
         */
        $pair = parent::current();

        return $pair->first;
    }


    /**
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed
     */
    public function current()
    {
        /**
         * @var Pair $pair
         */
        $pair = parent::current();

        return $pair->second;
    }


    /**
     * @link http://php.net/manual/en/countable.count.php
     * @return int
     */
    public function count()
    {
        return $this->size;
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
