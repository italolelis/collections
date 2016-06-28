<?php

namespace Tests\Collections;

use Collections\Map;
use Collections\Queue;
use Collections\Set;
use Collections\Stack;
use Collections\Vector;

class CollectionSerializerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider collectionProvider
     * @param $coll
     * @param $expectedSerialization
     */
    public function is_should_json_serialize_it($coll, $expectedSerialization)
    {
        $serializedColl = json_encode($coll);
        $this->assertJsonStringEqualsJsonString($serializedColl, $expectedSerialization);
    }

    /**
     * @test
     * @dataProvider collectionProvider
     * @param $coll
     */
    public function is_should_php_serialize_it($coll)
    {
        $serializedColl = serialize($coll);
        $this->assertInternalType("string", $serializedColl);
        $collection = unserialize($serializedColl);
        $this->assertInstanceOf(get_class($coll), $collection);
    }

    public function collectionProvider()
    {
        $data = [1, 2, 3, 4];

        $queue = new Queue();
        $queue->push(1);

        $stack = new Stack();
        $stack->push(1);

        return [
            [new Vector($data), '[1,2,3,4]'],
            [new Set($data), '[1,2,3,4]'],
            [new Map(['test' => 'test']), '{"test": "test"}'],
            [$queue, '[1]'],
            [$stack, '[1]'],
        ];
    }
}
