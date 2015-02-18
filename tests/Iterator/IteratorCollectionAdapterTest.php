<?php

namespace Tests\Collections\Iterator;

use Collections\Iterator\ArrayIterator;
use Collections\Iterator\IteratorCollectionAdapter;
use Collections\Iterator\ValueIterator;
use Tests\Collections\CollectionsTestCase;

class IteratorCollectionAdapterTest extends CollectionsTestCase
{

    public function testIteration()
    {
        $array = [1, 2, 3, 4, 5];
        $inner = new ArrayIterator($array);
        $iterator = new IteratorCollectionAdapter($inner);

        $i = 0;
        foreach ($iterator as $key => $value) {
            $this->assertEquals($i, $key);
            $this->assertEquals($array[$i++], $value);
        }
        $this->assertEquals(5, $i);
    }


    public function testLimit()
    {
        $iterator = new IteratorCollectionAdapter(new ArrayIterator([0]));
        $this->assertInstanceOf(
            'Collections\\Iterator\\LimitingIterator',
            $iterator->limit(0)
        );
    }


    public function testMap()
    {
        $iterator = new IteratorCollectionAdapter(new ArrayIterator([0]));
        $this->assertInstanceOf(
            'Collections\\Iterator\\MappingIterator',
            $iterator->map(function () {
            })
        );
    }


    public function testReduceEmpty()
    {
        $iterator = new IteratorCollectionAdapter(new ArrayIterator([]));
        $max = $iterator->reduce(10, 'max');
        $this->assertEquals(10, $max);
    }


    public function testReduceInitialIsMax()
    {
        $iterator = new IteratorCollectionAdapter(new ArrayIterator([0, 5]));
        $max = $iterator->reduce(10, 'max');
        $this->assertEquals(10, $max);
    }


    public function testReduce()
    {
        $iterator = new IteratorCollectionAdapter(new ArrayIterator([0, 5]));
        $max = $iterator->reduce(-5, 'max');
        $this->assertEquals(5, $max);
    }


    public function testSlice()
    {
        $iterator = new \ArrayIterator();
        $collection = new IteratorCollectionAdapter($iterator);
        $driver = new CollectionTestDriver();
        $driver->doSliceTests($collection, [$iterator, 'append']);
    }


    public function testSkip()
    {
        $iterator = new IteratorCollectionAdapter(new ArrayIterator([0]));
        $this->assertInstanceOf(
            'Collections\\Iterator\\SkippingIterator',
            $iterator->skip(0)
        );
    }


    public function testFilter()
    {
        $iterator = new IteratorCollectionAdapter(new ArrayIterator([0]));
        $this->assertInstanceOf(
            'Collections\\Iterator\\FilteringIterator',
            $iterator->filter(function () {
            })
        );
    }


    public function testValuesArray()
    {
        $array = [1, 2, 3];
        $iterator = new IteratorCollectionAdapter(new ArrayIterator($array));

        $this->assertEquals([1, 2, 3], $iterator->values()->toArray());
    }


    public function testValuesMap()
    {
        $array = ['one' => 1, 'two' => 2, 'three' => 3];
        $iterator = new IteratorCollectionAdapter(new ArrayIterator($array));

        $this->assertEquals([1, 2, 3], $iterator->values()->toArray());
    }


    public function testKeysArray()
    {
        $array = [1, 2, 3];
        $iterator = new IteratorCollectionAdapter(new ArrayIterator($array));

        $this->assertEquals([0, 1, 2], $iterator->keys()->toArray());
    }


    public function testKeysMap()
    {
        $array = ['one' => 1, 'two' => 2, 'three' => 3];
        $iterator = new IteratorCollectionAdapter(new ArrayIterator($array));

        $this->assertEquals(['one', 'two', 'three'], $iterator->keys()->toArray());
    }


    public function testValuesOnValuesReturnsSame()
    {
        $array = ['one' => 1, 'two' => 2, 'three' => 3];
        $iterator = new ValueIterator(new ArrayIterator($array));

        $this->assertSame($iterator, $iterator->values());

    }
}
