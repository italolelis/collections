<?php

namespace Tests\Collections;


abstract class BinaryTreeIteratorTest extends CollectionsTestCase
{
    /**
     * @return BinaryTreeIterator
     */
    abstract function instance();


    public function testIsEmptyEmptyReturnsTrue()
    {
        $iterator = $this->instance();
        $this->assertTrue($iterator->isEmpty());
    }


    public function testCountEmptyReturnsZero()
    {
        $iterator = $this->instance();
        $this->assertCount(0, $iterator);
    }

} 