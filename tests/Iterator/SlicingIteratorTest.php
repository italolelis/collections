<?php

namespace Tests\Collections\Iterator;

use Collections\Iterator\ArrayIterator;
use Tests\Collections\CollectionsTestCase;

class SlicingIteratorTest extends CollectionsTestCase
{

    public function provideCases()
    {
        $insert = [1, 2, 3, 4, 5];
        return [
            'empty' => [
                'insert' => [],
                'params' => [0, 2],
                'expect' => [],
            ],
            'beginning' => [
                'insert' => $insert,
                'params' => [0, 2],
                'expect' => [1, 2],
            ],
            'middle' => [
                'insert' => $insert,
                'params' => [2, 2],
                'expect' => [3, 4],
            ],
            'end' => [
                'insert' => $insert,
                'params' => [3, 2],
                'expect' => [4, 5],
            ],
            'more than available' => [
                'insert' => $insert,
                'params' => [3, 3],
                'expect' => [4, 5],
            ],
        ];
    }


    /**
     * @dataProvider provideCases
     */
    public function testCases(array $insert, array $params, array $expect)
    {
        $iterator = new ArrayIterator($insert);
        $slice = call_user_func_array([$iterator, 'slice'], $params);
        $this->assertEquals(count($expect), iterator_count($slice));
        $this->assertEquals($expect, $slice->values()->toArray());
    }

}
