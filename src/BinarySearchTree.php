<?php

namespace Collections;

interface BinarySearchTree extends \Countable, \IteratorAggregate
{
    /**
     * @param callable $f
     * @return mixed
     * @throws StateException when the tree is not empty
     */
    public function setCompare(callable $f);

    /**
     * @param mixed $element
     * @return void
     */
    public function add($element);

    /**
     * @param mixed $element
     * @return void
     */
    public function remove($element);

    /**
     * @param $element
     *
     * @return mixed
     * @throws LookupException
     */
    public function get($element);

    /**
     * @return BinaryTree A copy of the current BinaryTree
     */
    public function toBinaryTree();

    /**
     * @return void
     */
    public function clear();

    /**
     * @param $item
     *
     * @return bool
     * @throws TypeException when $item is not the correct type.
     */
    public function contains($item);

    /**
     * @return mixed
     * @throws EmptyException when the tree is empty
     */
    public function first();

    /**
     * @return mixed
     * @throws EmptyException when the tree is empty
     */
    public function last();

    /**
     * @return bool
     */
    public function isEmpty();

    /**
     * @return BinaryTreeIterator
     */
    public function getIterator();
}