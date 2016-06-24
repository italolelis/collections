<?php

namespace Tests\Collections;

use ArrayObject;
use Collections\ArrayList;
use Collections\Dictionary;
use Collections\Pair;
use OutOfBoundsException;

class DictionaryTest extends CollectionsTestCase
{
    /**
     * @var Dictionary
     */
    private $coll;

    protected function setUp()
    {
        $this->coll = new Dictionary();
    }

    public function testNewInstanceWithArray()
    {
        $this->assertNotNull(new Dictionary([
            'key1' => 'value1',
            'key2' => [
                'key21' => 'value21',
                'key22' => [
                    'key221' => 'value221',
                ]
            ],
            'key3' => 'value3',
            'key4' => 'value4'
        ]));
    }

    public function testNewInstanceWithTraversable()
    {
        $traversable = new ArrayObject(array(
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3',
            'key4' => 'value4'
        ));
        $this->assertNotNull(new Dictionary($traversable));
    }

    public function testNewInstance()
    {
        $this->assertNotNull($this->coll);
    }

    /**
     * @expectedException \Collections\Exception\InvalidArgumentException
     */
    public function testInvalidElementsToInstantiate()
    {
        $coll = new Dictionary();
        $coll->addAll('string');
    }

    public function testAddAllWithSomeValues()
    {
        $arrayList = new Dictionary();
        $arrayList
            ->add(new Pair('key1', 'value1'))
            ->add(new Pair('key2', 'value2'));

        $secoundArrayList = new Dictionary();
        $secoundArrayList
            ->add(new Pair('key3', 'value3'))
            ->add(new Pair('key4', 'value4'));

        $arrayList->addAll($secoundArrayList);
        $this->assertEquals([
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3',
            'key4' => 'value4'
        ], $arrayList->toArray());
    }

    public function testAddItem()
    {
        $this->coll->add(new Pair('key', 'testing'));
        $this->assertTrue(is_string((string)$this->coll));
    }

    /**
     * @expectedException \Collections\Exception\KeyException
     */
    public function testAddDuplicateKey()
    {
        $this->coll->add(new Pair('key', 'testing'));
        $this->coll->add(new Pair('key', 'testing2'));
    }

    public function testSetItem()
    {
        $this->coll->set('key', 'testing');
        $this->assertTrue(is_string((string)$this->coll));
    }

    public function testGetItem()
    {
        $this->coll->set('keyOne', 'testing');
        $this->assertEquals('testing', $this->coll->get('keyOne'));
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testGetInvalidItem()
    {
        $this->coll->set('keyOne', 'testing');
        $this->coll->at('keyTwo');
    }

    public function testGetKeys()
    {
        $this->coll->set('keyOne', 'testing1');
        $this->coll->set('keyTwo', 'testing2');
        $this->coll->set('keyThree', 'testing3');

        $this->assertEquals(array('keyOne', 'keyTwo', 'keyThree'), $this->coll->toKeysArray());
    }

    public function testTryGetSuccess()
    {
        $this->coll->set('key', 'testing');
        $value = $this->coll->get('key');
        $this->assertEquals('testing', $value);
    }

    public function testTryGetError()
    {
        $this->coll->add(new Pair('key', 'testing'));
        $value = $this->coll->get('key2');
        $this->assertNull($value);
    }

//    public function testTryGetDefaultValue()
//    {
//        $this->coll->set('key', 'testing');
//        $value = $this->coll->get('key2', 'testingValue');
//        $this->assertEquals('testingValue', $value);
//    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testRemovingNonExistentKeyReturnsNull()
    {
        $this->coll->removeKey('testing_does_not_exist');
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testRemovingNonExistentKey()
    {
        $this->coll->removeKey('testing_does_not_exist');
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testRemovingNonExistentElement()
    {
        $this->coll->remove('testing_does_not_exist');
    }

    public function testArrayAccess()
    {
        $this->coll['keyOne'] = 'one';
        $this->coll['keyTwo'] = 'two';

        $this->assertEquals($this->coll['keyOne'], 'one');
        $this->assertEquals($this->coll['keyTwo'], 'two');

        unset($this->coll['keyOne']);
        $this->assertEquals($this->coll->count(), 1);

        $this->assertTrue(isset($this->coll['keyTwo']));
    }

    public function testToList()
    {
        $this->coll->addAll([
            new Pair("key1", 1),
            new Pair("key2", 2),
            new Pair("key3", 3),
            new Pair("key4", 4)
        ]);
        $map = $this->coll->toVector();

        $this->assertInstanceOf(ArrayList::class, $map);
    }

    public function testToArray()
    {
        $data = [
            new Pair("key1", 'value1'),
            new Pair("key2", 'value2'),
            new Pair("key3", [
                'key3.1' => 'value3.1'
            ])
        ];
        $this->coll->addAll($data);
        $this->assertEquals([
            "key1" => 'value1',
            "key2" => 'value2',
            "key3" => [
                'key3.1' => 'value3.1'
            ]
        ], $this->coll->toArray());
    }

    public function testToValuesArray()
    {
        $dictionary = new Dictionary();
        $dictionary->set('key1', 'value1')->set('key2', 'value2');
        $expected = ['value1', 'value2'];
        $this->assertEquals($expected, $dictionary->toValuesArray());
    }
}
