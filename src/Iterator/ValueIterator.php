<?php

namespace Collections\Iterator;


class ValueIterator extends IteratorCollectionAdapter
{

    private $i = 0;


    public function values()
    {
        return $this;
    }


    public function rewind()
    {
        parent::rewind();
        $this->i = 0;
    }


    public function key()
    {
        return $this->i;
    }


    public function next()
    {
        parent::next();
        $this->i++;
    }
} 