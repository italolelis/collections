<?php

namespace Tests\Collections;

use ArrayObject;
use Collections\Dictionary;
use Collections\Exception\IndexException;
use InvalidArgumentException;
use OutOfBoundsException;
use stdClass;

/**
 * Description of CollectionTest
 *
 * @author italo
 */
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
        $this->assertNotNull(new Dictionary(array(
            'key1' => 'value1',
            'key2' => array(
                'key21' => 'value21',
                'key22' => array(
                    'key221' => 'value221',
                )
            ),
            'key3' => 'value3',
            'key4' => 'value4'
        )));
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
     * @expectedException InvalidArgumentException
     */
    public function testInvalidElementsToInstanciate()
    {
        $coll = new Dictionary();
        $coll->addAll('string');
    }

    public function testAddAllWithSomeValues()
    {
        $arrayList = new Dictionary();
        $arrayList->add('key1', 'value1')
            ->add('key2', 'value2');

        $secoundArrayList = new Dictionary();
        $secoundArrayList->add('key3', 'value3')
            ->add('key4', 'value4');

        $arrayList->addAll($secoundArrayList);
        $this->assertEquals(array(
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3',
            'key4' => 'value4'
        ), $arrayList->toArray());
    }

    public function testAddItem()
    {
        $this->coll->add('key', 'testing');
        $this->assertTrue(is_string((string)$this->coll));
    }

    /**
     * @expectedException \Collections\Exception\KeyException
     */
    public function testAddDuplicateKey()
    {
        $this->coll->add('key', 'testing');
        $this->coll->add('key', 'testing2');
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
     * @expectedException OutOfBoundsException
     */
    public function testGetInvalidItem()
    {
        $this->coll->set('keyOne', 'testing');
        $this->coll->get('keyTwo');
    }

    public function testGetKeys()
    {
        $this->coll->add('keyOne', 'testing1');
        $this->coll->add('keyTwo', 'testing2');
        $this->coll->add('keyThree', 'testing3');

        $this->assertEquals(array('keyOne', 'keyTwo', 'keyThree'), $this->coll->toKeysArray());
    }

    /**
     * @expectedException InvalidArgumentException
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
     * @expectedException \Collections\Exception\IndexException
     */
    public function testRemovingNonExistentEntryReturnsNull()
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
        $this->coll->addAll([1, 2, 3, 4]);
        $map = $this->coll->toVector();

        $this->assertInstanceOf('\Collections\\ArrayList', $map);
    }

    public function testToArray()
    {
        $data = [
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => [
                'key3.1' => 'value3.1'
            ]
        ];
        $this->coll->addAll($data);
        $this->assertEquals($data, $this->coll->toArray());
    }
}
