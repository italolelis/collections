<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tests\Collections;

use Collections\Enumerable;
use Collections\Map;
use Collections\MapInterface;
use Collections\Pair;
use Collections\QueueInterface;
use Collections\Set;
use Collections\StackInterface;
use Collections\Vector;
use Collections\VectorInterface;
use PHPUnit_Framework_TestCase;

/**
 * Description of Collection
 *
 * @author italo
 */
abstract class CollectionsTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var MapInterface|VectorInterface|StackInterface|QueueInterface
     */
    protected $coll;

    protected abstract function setUpCollection();

    protected function setUp()
    {
        date_default_timezone_set('America/Recife');
        $this->coll = $this->setUpCollection();
    }

    /**
     * @test
     */
    public function is_should_return_keys()
    {
        if ($this->coll instanceof MapInterface) {
            $this->coll->add(new Pair(0, 'value'));
        } else {
            $this->coll->add('value');
        }

        $keys = $this->coll->keys();

        $this->assertInstanceOf(VectorInterface::class, $keys);
        $this->assertEquals([0], $keys->toArray());
    }

    /**
     * @test
     */
    public function it_should_clear_the_collection()
    {
        if ($this->coll instanceof MapInterface) {
            $this->coll->add(new Pair(0, 'value'));
        } else {
            $this->coll->add('value');
        }

        $this->coll->clear();

        $this->assertTrue($this->coll->isEmpty());
    }

    /**
     * @test
     */
    public function is_should_concatenate_vectors()
    {
        if ($this->coll instanceof MapInterface) {
            $this->coll
                ->add(new Pair(0, 1))
                ->add(new Pair(1, 2))
                ->add(new Pair(3, 4));
        } else {
            $this->coll
                ->add(1)
                ->add(2)
                ->add(4);
        }

        $coll2 = new Vector([3]);
        $concatenated = $this->coll->concat($coll2);

        $this->assertEquals([
            1,
            2,
            4,
            3
        ], $concatenated->toArray());
    }

    /**
     * @test
     */
    public function is_should_concatenate_maps()
    {
        $coll3 = new Map([
            'key1' => 'value1',
            'key2' => 'wrongValue',
            'key3' => [
                'key31' => 'value31',
            ]
        ]);

        $coll4 = new Map([
            'key2' => 'value2',
            'key3' => [
                'key32' => 'value32'
            ]
        ]);
        $concatenated = $coll3->concat($coll4);

        $this->assertEquals([
            'key1' => 'value1',
            'key2' => [
                'wrongValue',
                'value2'
            ],
            'key3' => [
                'key31' => 'value31',
                'key32' => 'value32'
            ]
        ], $concatenated->toArray());
    }
}
