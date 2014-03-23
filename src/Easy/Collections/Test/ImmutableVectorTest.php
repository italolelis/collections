<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Easy\Collections\Test;

use Easy\Collections\ImmutableVector;
use OutOfBoundsException;

/**
 * @author italo
 */
class ImmutableVectorTest extends CollectionsTestCase
{

    /**
     * @var ImmutableVector
     */
    private $coll;

    protected function setUp()
    {
        $this->coll = new ImmutableVector(array(
            1, 2, 3, 4
        ));
    }

    public function testNewInstance()
    {
        $this->assertNotNull($this->coll);
    }

    public function testCount()
    {
        $this->assertEquals(4, $this->coll->count());
    }

    public function testContains()
    {
        $exists = $this->coll->contains(2);
        $this->assertTrue($exists);
        $exists = $this->coll->contains(10);
        $this->assertFalse($exists);
    }

    public function testGetItem()
    {
        $this->assertEquals(2, $this->coll->get(1));
    }

    /**
     * @expectedException OutOfBoundsException
     */
    public function testGetInvalidItem()
    {
        $this->coll->get(10);
    }

    public function testTryGetSuccess()
    {
        $value = $this->coll->tryGet(1);
        $this->assertEquals(2, $value);
    }

    public function testTryGetError()
    {
        $value = $this->coll->tryGet(10);
        $this->assertNull($value);
    }

}
