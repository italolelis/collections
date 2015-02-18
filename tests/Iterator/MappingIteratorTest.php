<?php

namespace Tests\Collections\Iterator;

use Collections\Iterator\ArrayIterator;
use Tests\Collections\CollectionsTestCase;

class MappingIteratorTest extends CollectionsTestCase
{

    public function provideCases()
    {
        $multiplyBy2 = function ($i) {
            return $i * 2;
        };
        return [
            'empty' => [
                'insert' => [],
                'map' => $multiplyBy2,
                'expect' => [],
            ],
            'map' => [
                'insert' => [0, 1, 2, 3],
                'map' => $multiplyBy2,
                'expect' => [0, 2, 4, 6],
            ],
        ];
    }


    /**
     * @dataProvider provideCases
     */
    public function testCases(array $insert, callable $map, array $expect)
    {
        $iterator = new ArrayIterator($insert);
        $mapped = $iterator->map($map);

        $this->assertCount(count($expect), $mapped);
        $this->assertEquals($expect, $mapped->toArray());
    }

}
