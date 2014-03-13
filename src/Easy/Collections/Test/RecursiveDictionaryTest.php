<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Easy\Collections\Test;

/**
 * Description of CollectionTest
 *
 * @author italo
 */
class RecursiveDictionaryTest extends CollectionsTestCase
{

    /**
     * @var \Easy\Collections\RecursiveDictionary
     */
    private $coll;

    protected function setUp()
    {
        $this->coll = new \Easy\Collections\RecursiveDictionary(array(
            'test1' => 'testeValue1',
            'test2' => array(
                'test2.1' => 'testeValue2.1',
                'test2.2' => 'testeValue2.2',
                'test2.3' => array(
                    'test2.3.1' => 'testeValue2.3.1'
                )
            )
        ));
    }

    public function testNewInstance()
    {
        $this->assertNotNull($this->coll);
    }

    public function testAddItem()
    {
        $this->coll->add('key', 'testing');
        $this->assertTrue(is_string((string) $this->coll));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddDuplicateKey()
    {
        $this->coll->add('key', 'testing');
        $this->coll->add('key', 'testing2');
    }

    public function testSetItem()
    {
        $this->coll->set('key', 'testing');
        $this->assertTrue(is_string((string) $this->coll));
    }

    public function testGetItem()
    {
        $this->coll->set('keyOne', 'testing');
        $this->assertEquals('testing', $this->coll->get('keyOne'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetNullKey()
    {
        $this->coll->set(null, 'testing');
    }

    public function testTryGetSuccess()
    {
        $this->coll->add('key', 'testing');
        $value = $this->coll->tryGet('key');
        $this->assertEquals('testing', $value);
    }

    public function testTryGetError()
    {
        $this->coll->add('key', 'testing');
        $value = $this->coll->tryGet('key2');
        $this->assertNull($value);
    }

    public function testTryGetDefaultValue()
    {
        $this->coll->add('key', 'testing');
        $value = $this->coll->tryGet('key2', 'testingValue');
        $this->assertEquals('testingValue', $value);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRemovingNonExistentEntryReturnsNull()
    {
        $this->assertEquals(null, $this->coll->remove('testing_does_not_exist'));
    }

}
