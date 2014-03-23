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

    /**
     * @expectedException \PHPUnit_Framework_Error
     */
    public function testNewInstanceWithArray()
    {
        $this->assertNotNull(new ArrayList(array(
            1, 2, 3, 4
        )));
    }

    public function testNewInstanceWithTraversable()
    {
        $traversable = new \ArrayObject(array(
            1, 2, 3, 4
        ));
        $this->assertNotNull(new ArrayList($traversable));
    }

    public function testNewInstance()
    {
        $this->assertNotNull($this->coll);
    }

    public function testAddAllWithSomeValues()
    {
        $arrayList = new ArrayList();
        $arrayList->add(1)
                ->add(2);

        $secoundArrayList = new ArrayList();
        $secoundArrayList->add(3)
                ->add(4);

        $arrayList->addAll($secoundArrayList);
        $this->assertEquals(array(
            0 => 1,
            1 => 2,
            2 => 3,
            3 => 4
                ), $arrayList->toArray());
    }

    public function testToString()
    {
        $this->coll->add('testing');
        $this->assertTrue(is_string((string) $this->coll));
    }

    public function testSort()
    {
        $this->coll->add('testing');
        $this->coll->sort();
        $this->assertTrue(is_array($this->coll->toArray()));
    }

    public function testSortByKey()
    {
        $this->coll->add('testing');
        $this->coll->sortByKey();
        $this->assertTrue(is_array($this->coll->toArray()));
    }

    public function testRemovingValueReturnsTrue()
    {
        $element = 'testing';
        $this->coll->add($element);
        $this->assertTrue($this->coll->removeValue($element));
    }

    public function testRemovingValueReturnsFalse()
    {
        $this->coll->add('testing');
        $this->assertFalse($this->coll->removeValue('nonExistentValue'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testRemovingNonExistentEntryReturnsNull()
    {
        $this->assertEquals(null, $this->coll->remove('testing_does_not_exist'));
    }

    public function testGetValues()
    {
        $this->coll->add('testing1');
        $this->coll->add('testing2');
        $this->assertEquals(array('testing1', 'testing2'), $this->coll->values());
    }

    public function testEquals()
    {
        $this->assertTrue($this->coll->equals($this->coll));
    }

    public function testNotEquals()
    {
        $this->assertFalse($this->coll->equals(new ArrayList()));
    }

    public function testInteratorInsntance()
    {
        $this->assertInstanceOf('ArrayIterator', $this->coll->getIterator());
    }

    public function testSerialize()
    {
        $this->coll->add('testing1');
        $this->coll->add('testing2');
        $this->assertNotEmpty($this->coll->serialize());
    }

    public function testUnserialize()
    {
        $this->coll->add('testing1');
        $this->coll->add('testing2');
        $this->assertNotEmpty($this->coll->unserialize($this->coll->serialize()));
    }

    public function testSetComparer()
    {
        $this->assertNotNull($this->coll->setDefaultComparer(new \Easy\Collections\Comparer\StringComparer()));
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
