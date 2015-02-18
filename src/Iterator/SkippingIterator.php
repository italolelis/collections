<?php

namespace Collections\Iterator;

class SkippingIterator extends IteratorCollectionAdapter
{

    /**
     * @var int
     */
    private $n;


    public function __construct(\Iterator $iterator, $n)
    {
        parent::__construct($iterator);
        $this->n = $n;
    }


    /**
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void
     */
    public function rewind()
    {
        $this->inner->rewind();

        for ($i = 0; $i < $this->n; $i++) {
            if ($this->inner->valid()) {
                $this->inner->next();
            }
        }
    }

}
