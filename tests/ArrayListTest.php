<?php

namespace Tests\Collections;

use ArrayObject;
use Collections\ArrayList;
use Collections\Comparer\StringComparer;
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
            1,
            2 => array(
                21,
                22 => array(
                    221,
                    222
                )
            ),
            3,
            4
        )));
    }

    public function testNewInstanceWithTraversable()
    {
        $traversable = new ArrayObject(array(
            1,
            2,
            3,
            4
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
        $arrayList
            ->add(1)
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
        $this->assertTrue(is_string((string)$this->coll));
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

        $key = $this->coll->indexOf($element);
        $this->coll->removeKey($key);

        $this->assertFalse($this->coll->containsKey($key));
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testRemovingValueThrowsException()
    {
        $element = 'testing';
        $this->coll->add($element);
        $this->coll->removeKey(-1);
    }

    /**
     * @expectedException \Collections\Exception\TypeException
     */
    public function testRemovingWrongType()
    {
        $this->coll->removeKey('testing_does_not_exist');
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
        $this->assertInstanceOf('\ArrayIterator', $this->coll->getIterator());
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

        $key = $this->coll->indexOf("one");

        $exists = $this->coll->containsKey($key);
        $this->assertTrue($exists);
    }

    /**
     * @expectedException \Collections\Exception\TypeException
     */
    public function testContainsWithWrongKeyType()
    {
        $this->coll->add("one");
        $this->coll->containsKey("other");
    }

    public function testExists()
    {
        $this->coll->add("one");
        $this->coll->add("two");
        $exists = $this->coll->exists(function ($e) {
            return $e == "one";
        });
        $this->assertTrue($exists);
        $exists = $this->coll->exists(function ($e) {
            return $e == "other";
        });
        $this->assertFalse($exists);
    }

    public function testFilter()
    {
        $this->coll->add(1);
        $this->coll->add("foo");
        $this->coll->add(3);
        $res = $this->coll->filter(function ($e) {
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

        $this->assertTrue(isset($this->coll[1]));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testTryToUnsetAnElement()
    {
        $this->coll[0] = 'one';
        unset($this->coll[0]);
    }

    /**
     * @expectedException \Collections\Exception\TypeException
     */
    public function testInvalidOffsetExists()
    {
        $this->coll[1] = 'one';
        $this->assertFalse(isset($this->coll['string']));
    }

    /**
     * @expectedException \Collections\Exception\TypeException
     */
    public function testInvalidOffsetSet()
    {
        $this->coll['string'] = 'one';
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

    public function testToMap()
    {
        $this->coll->addAll(array(1, 2, 3, 4));
        $map = $this->coll->toMap();

        $this->assertInstanceOf('\Collections\\Dictionary', $map);
    }
}