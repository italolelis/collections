<?php

namespace Tests\Collections\Iterator;

use Collections\Iterator\ArrayIterator;
use Tests\Collections\CollectionsTestCase;

class ArrayIteratorTest extends CollectionsTestCase
{

    public function testCount()
    {
        $array = [];
        $iterator = new ArrayIterator($array);

        $this->assertCount(count($array), $iterator);

        $array = [0];
        $iterator = new ArrayIterator($array);

        $this->assertCount(count($array), $iterator);

        $array = [0, 2, 4, 6];
        $iterator = new ArrayIterator($array);

        $this->assertCount(count($array), $iterator);
    }

    public function testIteration()
    {
        $array = [0, 2, 4, 8];
        $iterator = new ArrayIterator($array);

        $i = 0;
        $iterator->rewind();
        while ($i < count($array)) {
            $this->assertTrue($iterator->valid());
            $this->assertEquals($i, $iterator->key());
            $this->assertEquals($array[$i], $iterator->current());
            $iterator->next();
            $i++;
        }
    }

    public function testArrayToArray()
    {
        $array = [0, 2, 4, 8];
        $iterator = new ArrayIterator($array);

        $this->assertEquals($array, $iterator->toArray());
    }
}
