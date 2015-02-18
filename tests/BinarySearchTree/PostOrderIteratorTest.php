<?php

namespace Tests\Collections;

use Collections\BinaryTree;
use Collections\Iterator\PostOrderIterator;

class PostOrderIteratorTest extends BinaryTreeIteratorTest
{

    public function instance(BinaryTree $root = null, $count = 0)
    {
        return new PostOrderIterator($root, $count);
    }


    public function testToArray()
    {
        $tree = new BinaryTree(0);
        $tree->setLeft(new BinaryTree(-4));
        $tree->left()->setLeft(new BinaryTree(1));
        $tree->left()->setRight(new BinaryTree(2));

        $iterator = $this->instance($tree, 4);
        $expect = [1, 2, -4, 0];
        $actual = $iterator->toArray();
        $this->assertEquals($expect, $actual);
    }


} 