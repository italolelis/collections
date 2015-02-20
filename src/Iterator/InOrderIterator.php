<?php

namespace Collections\Iterator;

use Collections\BinaryTree;
use Collections\LinkedStack;

class InOrderIterator implements BinaryTreeIteratorInterface
{

    use IteratorCollectionTrait;

    /**
     * @var Stack
     */
    protected $stack;

    /**
     * @var BinaryTree
     */
    protected $root;

    /**
     * @var int
     */
    protected $key = null;

    /**
     * @var BinaryTree
     */
    protected $node;

    private $size = 0;


    public function __construct(BinaryTree $root = null, $count = 0)
    {
        $this->root = $root;
        $this->size = $count;
    }


    /**
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed
     */
    public function current()
    {
        return $this->node->value();
    }


    /**
     * @link http://php.net/manual/en/iterator.next.php
     * @return void
     */
    public function next()
    {
        /**
         * @var BinaryTree $node
         */
        $node = $this->stack->pop();

        $right = $node->right();
        if ($right !== null) {
            // left-most branch of the right side
            $this->pushLeft($right);
        }

        if ($this->stack->isEmpty()) {
            $this->node = null;
            return;
        }
        $this->node = $this->stack->last();

        $this->key++;
    }


    /**
     * @link http://php.net/manual/en/iterator.key.php
     * @return int|NULL
     */
    public function key()
    {
        return $this->key;
    }


    /**
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean
     */
    public function valid()
    {
        return $this->node !== null;
    }


    /**
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void
     */
    public function rewind()
    {
        $this->stack = new LinkedStack();

        $this->pushLeft($this->root);

        if (!$this->stack->isEmpty()) {
            $this->node = $this->stack->last();
            $this->key = 0;
        }
    }


    public function count()
    {
        return $this->size;
    }


    private function pushLeft(BinaryTree $n = null)
    {
        for ($current = $n; $current !== null; $current = $current->left()) {
            $this->stack->push($current);
        }
    }
}
