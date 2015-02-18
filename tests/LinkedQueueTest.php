<?php

namespace Tests\Collections;

use Collections\LinkedQueue;

class LinkedQueueTest extends CollectionsTestCase
{

    public function testPushOne()
    {
        $queue = new LinkedQueue();
        $this->assertCount(0, $queue);
        $this->assertTrue($queue->isEmpty());

        $queue->enqueue(0);
        $this->assertCount(1, $queue);
        $this->assertFalse($queue->isEmpty());
    }


    /**
     * @depends testPushOne
     */
    public function testPeekOne()
    {
        $queue = new LinkedQueue();
        $queue->enqueue(1);
        $this->assertCount(1, $queue);
        $this->assertFalse($queue->isEmpty());

        $peek = $queue->first();
        $this->assertCount(1, $queue);
        $this->assertFalse($queue->isEmpty());
        $this->assertEquals(1, $peek);
    }


    /**
     * @depends testPeekOne
     */
    public function testPopOne()
    {
        $queue = new LinkedQueue();
        $queue->enqueue(1);
        $this->assertCount(1, $queue);
        $this->assertFalse($queue->isEmpty());

        $pop = $queue->dequeue();
        $this->assertCount(0, $queue);
        $this->assertTrue($queue->isEmpty());
        $this->assertEquals(1, $pop);
    }


    /**
     * @depends testPopOne
     */
    public function testMultiplePushPeekPop()
    {
        $queue = new LinkedQueue();
        $queue->enqueue(1);
        $queue->enqueue(3);
        $queue->enqueue(5);

        $peek = $queue->first();
        $this->assertEquals(1, $peek);
        $this->assertCount(3, $queue);
        $this->assertFalse($queue->isEmpty());

        $pop = $queue->dequeue();
        $this->assertEquals(1, $pop);
        $this->assertCount(2, $queue);
        $this->assertFalse($queue->isEmpty());

        $peek = $queue->first();
        $this->assertEquals(3, $peek);
        $this->assertCount(2, $queue);
        $this->assertFalse($queue->isEmpty());

        $pop = $queue->dequeue();
        $this->assertEquals(3, $pop);
        $this->assertCount(1, $queue);
        $this->assertFalse($queue->isEmpty());

        $peek = $queue->first();
        $this->assertEquals(5, $peek);
        $this->assertCount(1, $queue);
        $this->assertFalse($queue->isEmpty());

        $pop = $queue->dequeue();
        $this->assertEquals(5, $pop);
        $this->assertCount(0, $queue);
        $this->assertTrue($queue->isEmpty());
    }


    /**
     * @expectedException \Collections\Exception\EmptyException
     */
    public function testPeekEmpty()
    {
        $queue = new LinkedQueue();
        $queue->first();
    }


    /**
     * @expectedException \Collections\Exception\EmptyException
     */
    public function testPopEmpty()
    {
        $queue = new LinkedQueue();
        $queue->dequeue();
    }


    public function testGetIteratorEmpty()
    {
        $queue = new LinkedQueue();
        $iterator = $queue->getIterator();
        $this->assertInstanceOf('Collections\\Iterator\\LinkedQueueIterator', $iterator);
    }


    /**
     * @depends testMultiplePushPeekPop
     */
    public function testIteratorForeach()
    {
        $queue = new LinkedQueue();
        $queue->enqueue(1);
        $queue->enqueue(2);
        $queue->enqueue(3);
        $queue->enqueue(4);

        $iterator = $queue->getIterator();
        $this->assertInstanceOf('Collections\\Iterator\\LinkedQueueIterator', $iterator);

        $this->assertCount(4, $iterator);

        $expectedKey = 0;
        $expectedValue = 1;
        $iterator->rewind();

        for ($i = 0; $i < 4; $i++) {
            $this->assertTrue($iterator->valid());
            $this->assertEquals($expectedKey++, $iterator->key());
            $this->assertEquals($expectedValue++, $iterator->current());
            $iterator->next();
        }

        $this->assertFalse($iterator->valid());

    }


    /**
     * @depends testPopOne
     */
    public function testContains()
    {
        $queue = new LinkedQueue();
        $this->assertFalse($queue->contains(0));

        $queue->enqueue(1);
        $this->assertFalse($queue->contains(0));

        $queue->enqueue(0);
        $this->assertTrue($queue->contains(0));

        $queue->dequeue();
        $this->assertTrue($queue->contains(0));

        $queue->dequeue();
        $this->assertFalse($queue->contains(0));
    }


    public function testClear()
    {
        $queue = new LinkedQueue();
        $queue->enqueue(0);
        $queue->clear();
        $this->assertCount(0, $queue);
    }


    public function testToArrayEmpty()
    {
        $queue = new LinkedQueue();
        $array = $queue->toArray();
        $this->assertTrue(is_array($array));
        $this->assertCount(0, $array);
    }


    public function testToArray()
    {
        $queue = new LinkedQueue();
        for ($i = 0; $i < 3; $i++) {
            $queue->enqueue($i);
        }
        $array = $queue->toArray();
        $this->assertTrue(is_array($array));
        $this->assertCount(3, $array);
        $i = 0;
        foreach ($array as $item) {
            $this->assertEquals($i++, $item);
        }
    }
}
