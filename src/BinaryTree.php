<?php

namespace Collections;


class BinaryTree
{
    /**
     * @var BinaryTree
     */
    private $left = null;
    /**
     * @var BinaryTree
     */
    private $right = null;
    private $value;
    private $height = 1;

    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return BinaryTree
     */
    public function right()
    {
        return $this->right;
    }

    /**
     * @return BinaryTree
     */
    public function left()
    {
        return $this->left;
    }

    /**
     * @param BinaryTree $node
     * @return void
     */
    public function setRight(BinaryTree $node = null)
    {
        $this->right = $node;
        $this->recalculateHeight();
    }

    /**
     * @param BinaryTree $node
     * @return void
     */
    public function setLeft(BinaryTree $node = null)
    {
        $this->left = $node;
        $this->recalculateHeight();
    }

    /**
     * @return int
     */
    public function height()
    {
        return $this->height;
    }

    /**
     * @return int
     */
    public function leftHeight()
    {
        return $this->left === null
            ? 0
            : $this->left->height();
    }

    /**
     * @return int
     */
    public function rightHeight()
    {
        return $this->right === null
            ? 0
            : $this->right->height();
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    public function recalculateHeight()
    {
        $this->height = max($this->leftHeight(), $this->rightHeight()) + 1;
    }

    /**
     * Note that this function is only safe to call when it has a predecessor.
     * @return BinaryTree
     */
    public function inOrderPredecessor()
    {
        $current = $this->left();
        while ($current->right() !== null) {
            $current = $current->right();
        }
        return $current;
    }

    public function __clone()
    {
        $this->left = $this->left === null
            ? null
            : clone $this->left;
        $this->right = $this->right === null
            ? null
            : clone $this->right;
    }
}