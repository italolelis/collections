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
}
