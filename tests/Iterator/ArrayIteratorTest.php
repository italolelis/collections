<?php

namespace Tests\Collections\Iterator;

use Collections\Iterator\VectorIterator;
use Tests\Collections\CollectionsTestCase;

class ArrayIteratorTest extends CollectionsTestCase
{

    public function testCount()
    {
        $array = [];
        $iterator = new VectorIterator($array);

        $this->assertCount(count($array), $iterator);

        $array = [0];
        $iterator = new VectorIterator($array);

        $this->assertCount(count($array), $iterator);

        $array = [0, 2, 4, 6];
        $iterator = new VectorIterator($array);

        $this->assertCount(count($array), $iterator);
    }

    public function testIteration()
    {
        $array = [0, 2, 4, 8];
        $iterator = new VectorIterator($array);

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
}
