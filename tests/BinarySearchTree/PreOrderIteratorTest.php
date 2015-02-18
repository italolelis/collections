<?php

namespace Tests\Collections;

use Collections\BinaryTree;
use Collections\Iterator\PreOrderIterator;

class PreOrderIteratorTest extends BinaryTreeIteratorTest
{

    public function instance(BinaryTree $root = null, $count = 0)
    {
        return new PreOrderIterator($root, $count);
    }


    public function testToArray()
    {
        $tree = new BinaryTree(0);
        $tree->setLeft(new BinaryTree(-4));
        $tree->left()->setLeft(new BinaryTree(1));
        $tree->left()->setRight(new BinaryTree(2));

        $iterator = $this->instance($tree, 4);
        $expect = [0, -4, 1, 2];
        $actual = $iterator->toArray();
        $this->assertEquals($expect, $actual);
    }


} 