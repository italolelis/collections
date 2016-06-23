<?php

namespace Tests\Collections;

use ArrayObject;
use Collections\Set;
use Collections\SetInterface;

class SetTest extends CollectionsTestCase
{
    /**
     * @var SetInterface
     */
    private $coll;

    protected function setUp()
    {
        $this->coll = new Set();
    }

    /**
     * @test
     * @expectedException \Collections\Exception\InvalidArgumentException
     */
    public function it_should_break_when_it_has_an_invalid_elements_to_instantiate()
    {
        $coll = new Set();
        $coll->addAll('string');
    }

    /**
     * @test
     */
    public function it_should_create_a_new_instance_with_array()
    {
        $this->assertNotNull(new Set(array(
            1,
            2 => [
                21,
                22 => [
                    221,
                    222
                ]
            ],
            3,
            4
        )));
    }

    /**
     * @test
     */
    public function it_should_create_a_new_instance_with_traversable()
    {
        $traversable = new ArrayObject(array(
            1,
            2,
            3,
            4
        ));
        $this->assertNotNull(new Set($traversable));
    }

    /**
     * @test
     */
    public function it_should_successfully_add_values()
    {
        $value = 'test';
        $this->coll->add($value);
        $this->assertSame($value, $this->coll->first());
    }

    /**
     * @test
     * @expectedException \Collections\Exception\ElementAlreadyExists
     */
    public function it_should_break_when_add_the_same_value()
    {
        $value = 'test';
        $this->coll->add($value);
        $this->coll->add($value);
    }
}
