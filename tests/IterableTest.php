<?php

namespace Tests\Collections;

use Collections\ArrayList;
use Collections\Dictionary;

class IterableTest extends CollectionsTestCase
{
    /**
     * @var ArrayList
     */
    private $coll;

    protected function setUp()
    {
        $this->coll = new ArrayList();
    }

    public function testGetValues()
    {
        $this->coll->add('testing1');
        $this->coll->add('testing2');
        $this->assertEquals(['testing1', 'testing2'], $this->coll->values()->toArray());
    }

    public function testGetFirstElement()
    {
        $this->coll
            ->add("test1")
            ->add("test2")
            ->add("test3");

        $this->assertSame("test1", $this->coll->first());
    }

    public function testGetFirstElementOfEmptyCollection()
    {
        $this->assertEmpty($this->coll->first());
    }

    public function testGetLastElement()
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

    public function testMap()
    {
        $this->coll
            ->add(1)
            ->add(2)
            ->add(3);

        $coll = $this->coll->map(function ($item) {
            return $item * 2;
        });

        $expected = new ArrayList([
            2,
            4,
            6
        ]);

        $this->assertSame($expected->toArray(), $coll->toArray());
    }

    public function testFilter()
    {
        $this->coll
            ->add(1)
            ->add(2)
            ->add(3);

        $coll = $this->coll->filter(function ($item) {
            return $item > 1;
        });

        $expected = new ArrayList([
            2,
            3
        ]);

        $this->assertSame($expected->toArray(), $coll->toArray());
    }

    public function testTake()
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

    public function testConcat()
    {
        $this->coll
            ->add(1)
            ->add(2)
            ->add(4);

        $coll2 = new ArrayList([3]);
        $this->coll->concat($coll2);

        $this->assertEquals([
            1,
            2,
            4,
            3
        ], $this->coll->toArray());

        $coll3 = new Dictionary([
            'key1' => 'value1',
            'key2' => 'wrongValue',
            'key3' => [
                'key31' => 'value31',
            ]
        ]);

        $coll4 = new Dictionary([
            'key2' => 'value2',
            'key3' => [
                'key32' => 'value32'
            ]
        ]);
        $coll3->concat($coll4);

        $this->assertEquals([
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => [
                'key31' => 'value31',
                'key32' => 'value32'
            ]
        ], $coll3->toArray());
    }

    /**
     * @dataProvider diffProvider
     */
    public function testDiff($one, $two, $callback, $expected)
    {
        $actual = $one->diff($two, $callback);

        $this->assertEquals(array_values($expected), array_values($actual->toArray()));
    }

    public function diffProvider()
    {
        return [
            // Simple === diff
            [
                new ArrayList([ 'grün', 'rot', 'blau', 'rot' ]),
                new ArrayList([ 'grün', 'gelb', 'rot' ]),
                null,
                [ 2 => 'blau' ],
            ],

            // diff with callback
            [
                new ArrayList([ 'grün', 'rot', 'blau', 'rot' ]),
                new ArrayList([ 'gruen', 'gelb', 'rot' ]),
                function ($one, $two) {
                    return str_replace('ü', 'ue', $one) <=> $two;
                },
                [ 2 => 'blau' ]
            ],

            // equatable diff
            [
                new ArrayList([ new EquatableClass('bob'), new EquatableClass('bill') ]),
                new ArrayList([ new EquatableClass('bob') ]),
                null,
                [ new EquatableClass('bill') ]
            ]
        ];
    }
}
