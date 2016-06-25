<?php

namespace Tests\Collections\Iterator;

use Collections\Iterator\LazyConcatIterator;
use Collections\Iterator\LazyFilterIterator;
use Collections\Iterator\LazyFilterKeyedIterator;
use Collections\Iterator\LazyFilterWithKeyIterator;
use Collections\Iterator\LazyMapIterator;
use Collections\Iterator\LazyMapKeyedIterator;
use Collections\Iterator\LazySkipIterator;
use Collections\Iterator\LazySkipKeyedIterator;
use Collections\Iterator\MapIterator;
use Collections\Iterator\PairIterator;
use Collections\Iterator\SetIterator;
use Collections\Iterator\VectorIterator;

class ArrayIteratorTest extends \PHPUnit_Framework_TestCase
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

    /**
     * @test
     * @dataProvider iteratorProvider
     * @param \Iterator $iterator
     * @param array $array
     */
    public function it_should_iterate_over_iterators(\Iterator $iterator, array $array)
    {
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

    public function iteratorProvider()
    {
        $array = [0, 2, 4, 8];
        $array2 = [0, 3];

        $fnFilter = function ($i) {
            return $i >= 0;
        };

        $fnMap = function ($i) {
            return $i;
        };

        return [
            [new VectorIterator($array), $array],
            [new MapIterator($array), $array],
            [new SetIterator($array), $array],
            [new PairIterator($array), $array],
            [new LazyConcatIterator(new \ArrayIterator($array), new \ArrayIterator($array2)), $array],
            [new LazyFilterIterator(new \ArrayIterator($array), $fnFilter), $array],
            [new LazyFilterKeyedIterator(new \ArrayIterator($array), $fnFilter), $array],
            [new LazyFilterWithKeyIterator(new \ArrayIterator($array), $fnFilter), $array],
            [new LazyMapIterator(new \ArrayIterator($array), $fnMap), $array],
            [new LazyMapKeyedIterator(new \ArrayIterator($array), $fnMap), $array],
            [new LazySkipIterator(new \ArrayIterator($array), 0), $array],
            [new LazySkipKeyedIterator(new \ArrayIterator($array), 0), $array]
        ];
    }
}
