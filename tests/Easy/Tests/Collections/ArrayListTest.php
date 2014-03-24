<?php

namespace Easy\Tests\Collections;

use ArrayObject;
use Easy\Collections\ArrayList;
use Easy\Collections\Comparer\StringComparer;
use InvalidArgumentException;

class ArrayListTest extends CollectionsTestCase
{

    /**
     * @var ArrayList
     */
    private $coll;

    protected function setUp()
    {
        $this->coll = new ArrayList();
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidElementsToInstanciate()
    {
        $coll = new ArrayList();
        $coll->addAll('string');
    }

    public function testNewInstanceWithArray()
    {
        $this->assertNotNull(new ArrayList(array(
            1, 2 => array(
                21, 22 => array(
                    221, 222
                )
            ), 3, 4
        )));
    }

    public function testNewInstanceWithTraversable()
    {
        $traversable = new ArrayObject(array(
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
                ->add(new ArrayList(array(31)));

        $arrayList->addAll($secoundArrayList);
        $this->assertEquals(array(
            0 => 1,
            1 => 2,
            2 => 3,
            3 => array(
                0 => 31
            )
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
        $this->assertNotNull($this->coll->setDefaultComparer(new StringComparer()));
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
        $this->assertTrue(isset($this->coll[1]));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidOffsetExists()
    {
        $this->coll[1] = 'one';
        $this->assertFalse(isset($this->coll['string']));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testNegativeOffsetExists()
    {
        $this->coll[1] = 'one';
        $this->assertFalse(isset($this->coll[-1]));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidOffsetSet()
    {
        $this->coll['string'] = 'one';
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testNegativeOffsetSet()
    {
        $this->coll[-1] = 'one';
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

    public function testSlice()
    {
        $this->coll->addAll(array(1, 2, 3, 4));
        $slice = $this->coll->slice(2);

        $this->assertEquals(array(0 => 3, 1 => 4), $slice->toArray());
    }

//    public function testSplice()
//    {
//        $this->coll->addAll(array(1, 2, 3, 4));
//        $splice = $this->coll->splice(2);
//
//        $this->assertEquals(array(0 => 1, 1 => 2), $splice->toArray());
//    }

    public function testToMap()
    {
        $this->coll->addAll(array(1, 2, 3, 4));
        $map = $this->coll->toMap();

        $this->assertInstanceOf('Easy\\Collections\\Dictionary', $map);
    }

}
