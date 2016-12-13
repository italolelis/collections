<?php

namespace Tests\Collections;

use Collections\Enumerable;
use Collections\Map;
use Collections\Set;
use Collections\Vector;

class EnumerableTest extends CollectionsTestCase
{
    protected function setUpCollection()
    {
        return new Vector();
    }

    /**
     * @test
     */
    public function it_should_get_values()
    {
        $this->coll->add('testing1');
        $this->coll->add('testing2');

        $values = $this->coll->values();

        $this->assertInstanceOf(Vector::class, $values);
        $this->assertEquals(['testing1', 'testing2'], $values->toArray());
    }

    /**
     * @test
     */
    public function it_should_get_first_element()
    {
        $this->coll
            ->add("test1")
            ->add("test2")
            ->add("test3");

        $this->assertSame("test1", $this->coll->first());
    }

    /**
     * @test
     */
    public function it_should_get_first_element_of_empty_collection()
    {
        $this->assertEmpty($this->coll->first());
    }

    /**
     * @test
     */
    public function it_should_get_last_element()
    {
        $this->coll
            ->add("test1")
            ->add("test2")
            ->add("test3");

        $this->assertSame("test3", $this->coll->last());
    }

    public function testGetLastElementOfEmptyCollection()
    {
        $this->assertEmpty($this->coll->last());
    }

    /**
     * @test
     */
    public function it_should_map()
    {
        $this->coll
            ->add(1)
            ->add(2)
            ->add(3);

        $coll = $this->coll->map(function ($item) {
            return $item * 2;
        });

        $this->assertSame([
            2,
            4,
            6
        ], $coll->toArray());
    }

    /**
     * @test
     */
    public function it_should_map_with_keys()
    {
        $this->coll
            ->add(1)
            ->add(2)
            ->add(3);

        $coll = $this->coll->mapWithKey(function ($key, $item) {
            return $key;
        });

        $this->assertSame([
            0,
            1,
            2
        ], $coll->toArray());
    }

    /**
     * @test
     */
    public function it_should_take_2_elements()
    {
        $this->coll
            ->add(1)
            ->add(2)
            ->add(3);

        $this->assertSame([
            1,
            2
        ], $this->coll->take(2)->toArray());
    }

    /**
     * @test
     * @dataProvider filterProvider
     */
    public function it_should_filter_successfully(Enumerable $coll, $expected)
    {
        $coll = $coll->filter(function ($item) {
            return $item > 1;
        });

        $this->assertEquals($expected, $coll->toArray());
    }

    public function filterProvider()
    {
        return [
            [new Map([0 => 1, 1 => 2, 2 => 3]), [1 => 2, 2 => 3]],
            [new Vector([1, 2, 3]), [2, 3]],
            [new Set([1, 2, 3]), [2, 3]]
        ];
    }

    /**
     * @test
     */
    public function it_should_group_by_callable()
    {
        $items = [
            ['id' => 1, 'name' => 'foo', 'parent_id' => 10],
            ['id' => 2, 'name' => 'bar', 'parent_id' => 11],
            ['id' => 3, 'name' => 'baz', 'parent_id' => 10],
        ];
        $collection = new Map($items);
        $grouped = $collection->groupBy(function ($item) {
            return $item['parent_id'];
        });
        $expected = [
            10 => [
                ['id' => 1, 'name' => 'foo', 'parent_id' => 10],
                ['id' => 3, 'name' => 'baz', 'parent_id' => 10],
            ],
            11 => [
                ['id' => 2, 'name' => 'bar', 'parent_id' => 11],
            ]
        ];
        $this->assertEquals($expected, $grouped->toArray());
        $this->assertInstanceOf('Collections\CollectionInterface', $grouped);
        $grouped = $collection->groupBy(function ($element) {
            return $element['parent_id'];
        });
        $this->assertEquals($expected, $grouped->toArray());
    }

    /**
     * @test
     */
    public function it_should_group_by_key_deep()
    {
        $items = [
            ['id' => 1, 'name' => 'foo', 'thing' => ['parent_id' => 10]],
            ['id' => 2, 'name' => 'bar', 'thing' => ['parent_id' => 11]],
            ['id' => 3, 'name' => 'baz', 'thing' => ['parent_id' => 10]],
        ];
        $collection = new Map($items);
        $grouped = $collection->groupBy(function ($element) {
            return $element['thing']['parent_id'];
        });
        $expected = [
            10 => [
                ['id' => 1, 'name' => 'foo', 'thing' => ['parent_id' => 10]],
                ['id' => 3, 'name' => 'baz', 'thing' => ['parent_id' => 10]],
            ],
            11 => [
                ['id' => 2, 'name' => 'bar', 'thing' => ['parent_id' => 11]],
            ]
        ];
        $this->assertEquals($expected, $grouped->toArray());
    }

    /**
     * @test
     */
    public function it_should_index_by_callable()
    {
        $items = [
            ['id' => 1, 'name' => 'foo', 'parent_id' => 10],
            ['id' => 2, 'name' => 'bar', 'parent_id' => 11],
            ['id' => 3, 'name' => 'baz', 'parent_id' => 10],
        ];
        $collection = new Map($items);
        $grouped = $collection->indexBy(function ($element) {
            return $element['id'];
        });
        $expected = [
            1 => ['id' => 1, 'name' => 'foo', 'parent_id' => 10],
            3 => ['id' => 3, 'name' => 'baz', 'parent_id' => 10],
            2 => ['id' => 2, 'name' => 'bar', 'parent_id' => 11],
        ];
        $this->assertEquals($expected, $grouped->toArray());
        $this->assertInstanceOf('Collections\CollectionInterface', $grouped);
        $grouped = $collection->indexBy(function ($element) {
            return $element['id'];
        });
        $this->assertEquals($expected, $grouped->toArray());
    }

    /**
     * @test
     */
    public function it_should_index_deep()
    {
        $items = [
            ['id' => 1, 'name' => 'foo', 'thing' => ['parent_id' => 10]],
            ['id' => 2, 'name' => 'bar', 'thing' => ['parent_id' => 11]],
            ['id' => 3, 'name' => 'baz', 'thing' => ['parent_id' => 10]],
        ];
        $collection = new Map($items);
        $grouped = $collection->indexBy(function ($element) {
            return $element['thing']['parent_id'];
        });
        $expected = [
            10 => ['id' => 3, 'name' => 'baz', 'thing' => ['parent_id' => 10]],
            11 => ['id' => 2, 'name' => 'bar', 'thing' => ['parent_id' => 11]],
        ];
        $this->assertEquals($expected, $grouped->toArray());
    }
}
