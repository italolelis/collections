<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Easy\Collections\Test;

use BadFunctionCallException;
use Easy\Collections\Queue;

/**
 * @author italo
 */
class QueueTest extends CollectionsTestCase
{

    /**
     * @var Queue
     */
    private $coll;

    protected function setUp()
    {
        $this->coll = new Queue();
    }

    public function testNewInstance()
    {
        $this->assertNotNull($this->coll);
    }

    public function testEnqueueItem()
    {
        $this->coll->enqueue('testing');
        $this->assertTrue(is_string((string) $this->coll));
    }

    /**
     * @expectedException BadFunctionCallException
     */
    public function testDequeueEmptyQueue()
    {
        $this->coll->dequeue();
    }

    /**
     * @expectedException BadFunctionCallException
     */
    public function testPeekEmptyQueue()
    {
        $this->coll->peek();
    }

    public function testPeekItem()
    {
        $this->coll->enqueue('testing');
        $this->assertEquals('testing', $this->coll->peek());
    }

    public function testEnqueueToArray()
    {
        $this->coll->enqueue('testing1');
        $this->coll->enqueue('testing2');
        $this->coll->enqueue('testing3');

        $this->assertEquals(array('testing1', 'testing2', 'testing3'), $this->coll->toArray());
    }

    public function testEnqueueAndDequeueToArray()
    {
        $this->coll->enqueue('testing1');
        $this->coll->enqueue('testing2');
        $this->coll->enqueue('testing3');

        $this->coll->dequeue();

        $this->assertEquals(array('testing2', 'testing3'), $this->coll->toArray());
    }

}
