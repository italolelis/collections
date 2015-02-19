<?php

namespace Collections\Iterator;

use Collections\BinaryTree;
use Collections\LinkedStack;

class PostOrderIterator implements BinaryTreeIteratorInterface
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
     * @var BinaryTree
     */
    protected $value;

    /**
     * @var BinaryTree
     */
    protected $current;

    protected $key = -1;

    private $size = 0;

    public function __construct(BinaryTree $root = null, $count = 0)
    {
        $this->root = $root;
        $this->size = $count;
    }

    public function count()
    {
        return $this->size;
    }

    /**
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void
     */
    public function rewind()
    {
        $this->stack = new LinkedStack();

        $this->value = $this->root;
        $this->key = -1;
        $this->next();
    }

    /**
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean
     */
    public function valid()
    {
        return $this->current !== null;
    }

    /**
     * @link http://php.net/manual/en/iterator.key.php
     * @return int
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed
     */
    public function current()
    {
        return $this->current->value();
    }

    /**
     * @link http://php.net/manual/en/iterator.next.php
     * @return void
     */
    public function next()
    {
        if ($this->value !== null) {
            $this->nextValueNotNull();
            return;
        }

        if ($this->stack->isEmpty()) {
            $this->nextSet();
            return;
        }

        $this->value = $this->stack->pop();

        $this->nextRight();
    }

    private function nextRight()
    {
        $right = $this->value->right();
        if ($right !== null && !$this->stack->isEmpty() && $right === $this->stack->last()) {
            $this->stack->pop();
            $this->nextPush($right);
        } else {
            $this->nextSet();
        }
    }

    private function nextValueNotNull()
    {
        $right = $this->value->right();
        if ($right !== null) {
            $this->stack->push($right);
        }
        $this->nextPush($this->value->left());
    }

    private function nextSet()
    {
        $this->current = $this->value;
        $this->key++;
        $this->value = null;
    }

    private function nextPush(BinaryTree $n = null)
    {
        $this->stack->push($this->value);
        $this->value = $n;
        $this->next();
    }
}
