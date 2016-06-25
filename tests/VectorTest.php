<?php

namespace Tests\Collections;

use ArrayObject;
use Collections\Comparer\StringComparer;
use Collections\Map;
use Collections\Vector;

class VectorTest extends CollectionsTestCase
{
    protected function setUpCollection()
    {
        return new Vector();
    }

    /**
     * @expectedException \Collections\Exception\InvalidArgumentException
     */
    public function testInvalidElementsToInstantiate()
    {
        $coll = new Vector();
        $coll->addAll('string');
    }

    public function testNewInstanceWithArray()
    {
        $this->assertNotNull(new Vector([
            1,
            2 => [
                21,
                22 => [
                    221,
                    222
                ]
            ],
            3,
            4
        ]));
    }

    public function testNewInstanceWithTraversable()
    {
        $traversable = new ArrayObject(range(1, 4));
        $this->assertNotNull(new Vector($traversable));
    }

    public function testNewInstance()
    {
        $this->assertNotNull($this->coll);
    }

    /**
     * @test
     */
    public function it_should_create_vector_from_items()
    {
        $data = range(1, 10);
        $vector = Vector::fromItems($data);

        $this->assertNotNull($vector);
    }

    public function testAddAllWithSomeValues()
    {
        $arrayList = new Vector();
        $arrayList
            ->add(1)
            ->add(2);

        $secoundArrayList = new Vector();
        $secoundArrayList
            ->add(3)
            ->add(new Vector([31]));

        $arrayList->addAll($secoundArrayList);

        $this->assertEquals([
            0 => 1,
            1 => 2,
            2 => 3,
            3 => [
                0 => 31
            ]
        ], $arrayList->toArray());
    }

    public function testToString()
    {
        $this->coll->add('testing');
        $this->assertTrue(is_string((string)$this->coll));
    }

    public function testGetValueByIndex()
    {
        $value = 'testing';

        $this->coll->add($value);
        $this->assertSame($value, $this->coll->get(0));
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
        $this->assertFalse($this->coll->equals(new Vector()));
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
        $this->coll->addAll(range(1, 4));
        $map = $this->coll->toMap();

        $this->assertInstanceOf(Map::class, $map);
    }

    public function testReduce()
    {
        $this->coll->addAll(range(1, 4));
        $result = $this->coll->reduce(function ($carry, $item) {
            return $carry += $item;
        });

        $this->assertEquals(10, $result);

        $result = $this->coll->reduce(function ($carry, $item) {
            return $carry += $item;
        }, 10);

        $this->assertEquals(20, $result);
    }

    /**
     * @test
     */
    public function it_should_reverse_the_collection()
    {
        $coll = new Vector(range(1, 5));

        $this->assertSame([
            5,
            4,
            3,
            2,
            1
        ], $coll->reverse()->toArray());
    }
}
