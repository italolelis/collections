<?php

namespace Tests\Collections;

use Collections\Vector;
use Collections\Dictionary;

class RxTest extends CollectionsTestCase
{

    public function peopleProvider()
    {
        $user = new \stdClass();
        $user->name = 'Test';

        $male = new \stdClass();
        $male->name = 'Marc';
        $male->user = $user;
        $male->gender = 'male';
        $male->age = 40;

        $male2 = new \stdClass();
        $male2->name = 'Anderson';
        $male2->user = $user;
        $male2->gender = 'male';
        $male2->age = 19;

        $female = new \stdClass();
        $female->name = 'Ana Martha';
        $female->user = $user;
        $female->gender = 'female';
        $female->age = 21;

        $female2 = new \stdClass();
        $female2->name = 'Daize';
        $female2->gender = 'female';
        $female2->age = 30;

        return [
            [new Vector([$male, $male2, $female, $female2])]
        ];
    }

    /**
     * Tests groupBy
     *
     * @return void
     */
    public function testGroupBy()
    {
        $items = [
            ['id' => 1, 'name' => 'foo', 'parent_id' => 10],
            ['id' => 2, 'name' => 'bar', 'parent_id' => 11],
            ['id' => 3, 'name' => 'baz', 'parent_id' => 10],
        ];
        $collection = new Dictionary($items);
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
     * Tests grouping by a deep key
     *
     * @return void
     */
    public function testGroupByDeepKey()
    {
        $items = [
            ['id' => 1, 'name' => 'foo', 'thing' => ['parent_id' => 10]],
            ['id' => 2, 'name' => 'bar', 'thing' => ['parent_id' => 11]],
            ['id' => 3, 'name' => 'baz', 'thing' => ['parent_id' => 10]],
        ];
        $collection = new Dictionary($items);
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
     * Tests indexBy
     *
     * @return void
     */
    public function testIndexBy()
    {
        $items = [
            ['id' => 1, 'name' => 'foo', 'parent_id' => 10],
            ['id' => 2, 'name' => 'bar', 'parent_id' => 11],
            ['id' => 3, 'name' => 'baz', 'parent_id' => 10],
        ];
        $collection = new Dictionary($items);
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
     * Tests indexBy with a deep property
     *
     * @return void
     */
    public function testIndexByDeep()
    {
        $items = [
            ['id' => 1, 'name' => 'foo', 'thing' => ['parent_id' => 10]],
            ['id' => 2, 'name' => 'bar', 'thing' => ['parent_id' => 11]],
            ['id' => 3, 'name' => 'baz', 'thing' => ['parent_id' => 10]],
        ];
        $collection = new Dictionary($items);
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