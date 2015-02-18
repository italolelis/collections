<?php

namespace Tests\Collections\Iterator;

use Collections\Iterator\ArrayIterator;
use Tests\Collections\CollectionsTestCase;

class SkippingIteratorTest extends CollectionsTestCase
{

    public function provideCases()
    {
        $insert = [1, 2, 3, 4, 5];
        return [
            'empty' => [
                'insert' => [],
                'skip' => 2,
                'expect' => [],
                'expectPreserveKeys' => [],
            ],
            'all' => [
                'insert' => $insert,
                'skip' => count($insert),
                'expect' => [],
                'expectPreserveKeys' => [],
            ],
            'too many' => [
                'insert' => $insert,
                'skip' => count($insert) + 1,
                'expect' => [],
                'expectPreserveKeys' => [],
            ],
            '2' => [
                'insert' => $insert,
                'skip' => 2,
                'expect' => [3, 4, 5],
                'expectPreserveKeys' => [
                    2 => 3,
                    3 => 4,
                    4 => 5
                ],
            ],
            '-2' => [
                'insert' => $insert,
                'skip' => -2,
                'expect' => $insert,
                'expectPreserveKeys' => $insert,
            ],
        ];
    }


    /**
     * @dataProvider provideCases
     */
    public function testCases(array $insert, $skip, array $expect, array $expectPreserveKeys)
    {
        $iterator = new ArrayIterator($insert);
        $skipped = $iterator->skip($skip);

        $this->assertEquals(count($expect), iterator_count($skipped));
        $this->assertEquals($expect, $skipped->values()->toArray());
        $this->assertEquals($expectPreserveKeys, $skipped->toArray());

    }

}
