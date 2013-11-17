<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Easy\Collections\Test;

use Easy\Collections\ArrayList;
use InvalidArgumentException;

/**
 * Description of CollectionTest
 *
 * @author italo
 */
class ArrayListTest extends CollectionsTestCase
{

    /**
     * @var \Easy\Collections\ArrayList
     */
    private $coll;

    protected function setUp()
    {
        $this->coll = new ArrayList();
    }

    public function testNewInstance()
    {
        $this->assertNotNull($this->coll);
    }

    public function testToString()
    {
        $this->coll->add('testing');
        $this->assertTrue(is_string((string) $this->coll));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testRemovingNonExistentEntryReturnsNull()
    {
        $this->assertEquals(null, $this->coll->remove('testing_does_not_exist'));
    }

    public function testContains()
    {
        $this->coll->add("one");
        $this->coll->add("two");
        $exists = $this->coll->contains("one");
        $this->assertTrue($exists);
        $exists = $this->coll->contains("other");
        $this->assertFalse($exists);
    }

    public function testExists()
    {
        $this->coll->add("one");
        $this->coll->add("two");
        $exists = $this->coll->exists(function($k, $e) {
            return $e == "one";
        });
        $this->assertTrue($exists);
        $exists = $this->coll->exists(function($k, $e) {
            return $e == "other";
        });
        $this->assertFalse($exists);
    }

    public function testFilter()
    {
        $this->coll->add(1);
        $this->coll->add("foo");
        $this->coll->add(3);
        $res = $this->coll->filter(function($e) {
            return is_numeric($e);
        });
        $this->assertEquals(array(0 => 1, 1 => 3), $res->toArray());
    }

    public function testArrayAccess()
    {
        $this->coll[0] = 'one';
        $this->coll[1] = 'two';

        $this->assertEquals($this->coll[0], 'one');
        $this->assertEquals($this->coll[1], 'two');

        unset($this->coll[0]);
        $this->assertEquals($this->coll->count(), 1);
    }

    public function testSearch()
    {
        $this->coll[0] = 'test';
        $this->assertEquals(0, $this->coll->indexOf('test'));
    }

    public function testCount()
    {
        $this->coll[0] = 'one';
        $this->coll[1] = 'two';
        $this->assertEquals($this->coll->count(), 2);
        $this->assertEquals(count($this->coll), 2);
    }

    public function testClear()
    {
        $this->coll[0] = 'one';
        $this->coll[1] = 'two';
        $this->coll->clear();
        $this->assertEquals($this->coll->isEmpty(), true);
    }

}
