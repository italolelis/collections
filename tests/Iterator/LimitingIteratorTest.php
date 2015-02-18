<?php

namespace Tests\Collections\Iterator;

use Collections\Iterator\ArrayIterator;
use Collections\Iterator\LimitingIterator;
use Tests\Collections\CollectionsTestCase;

class MethodCallCountingIterator implements \OuterIterator
{

    private $calls = [
        'rewind' => 0,
        'valid' => 0,
        'current' => 0,
        'key' => 0,
        'next' => 0,
    ];
    private $inner;


    public function __construct(\Iterator $i)
    {
        $this->inner = $i;
    }


    public function rewind()
    {
        $this->calls[__FUNCTION__]++;
        $this->inner->rewind();
    }


    function valid()
    {
        $this->calls[__FUNCTION__]++;
        return $this->inner->valid();
    }


    function key()
    {
        $this->calls[__FUNCTION__]++;
        return $this->inner->key();
    }


    function current()
    {
        $this->calls[__FUNCTION__]++;
        return $this->inner->current();
    }


    function next()
    {
        $this->calls[__FUNCTION__]++;
        $this->inner->next();
    }


    function getInnerIterator()
    {
        return $this->inner;
    }


    function getMethodCallCount($method)
    {
        return isset($this->calls[$method])
            ? $this->calls[$method]
            : 0;
    }
}

class LimitingIteratorTest extends CollectionsTestCase
{

    public function provideCases()
    {
        return [
            'empty' => [
                'insert' => [],
                'limit' => 2,
                'expect' => []
            ],
            'zero' => [
                'insert' => [1, 4, 5],
                'limit' => 0,
                'expect' => []
            ],
            'limit' => [
                'insert' => [1, 4, 5],
                'limit' => 2,
                'expect' => [1, 4]
            ],
            'limit extra' => [
                'insert' => [1, 4, 5],
                'limit' => 4,
                'expect' => [1, 4, 5]
            ],
        ];
    }


    /**
     * @dataProvider provideCases
     */
    public function testCases(array $insert, $limit, array $expect)
    {
        $iterator = new ArrayIterator($insert);
        $limited = $iterator->limit($limit);
        $this->assertCount(count($expect), $limited);
        $this->assertEquals($expect, $limited->toArray());
    }


    public function provideInnerIteratorCases()
    {
        $data = [1, 2, 3];
        return [
            [$data, 1, 0],
            [$data, 2, 1],
            [$data, 3, 2],
        ];
    }


    /**
     * @dataProvider provideInnerIteratorCases
     */
    public function testCorrectNumberOfCallsToInnerIteratorsNext(array $data, $limit, $callCount)
    {

        $inner = new MethodCallCountingIterator(new ArrayIterator($data));
        $iterator = new LimitingIterator($inner, $limit);
        $i = 0;
        foreach ($iterator->limit($limit) as $val) {
            $this->assertEquals($data[$i++], $val);
        }
        $this->assertEquals($callCount, $inner->getMethodCallCount('next'));
    }
}
