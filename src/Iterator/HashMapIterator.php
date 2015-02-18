<?php

namespace Collections\Iterator;

class HashMapIterator extends IteratorCollectionAdapter implements MapIterator
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

}
