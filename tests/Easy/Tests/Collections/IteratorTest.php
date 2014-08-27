<?php

namespace Easy\Tests\Collections;

use Easy\Collections\ArrayList;
use RegexIterator;

class IteratorTest extends CollectionsTestCase
{
    /**
     * @var ArrayList
     */
    private $coll;

    protected function setUp()
    {
        $this->coll = new ArrayList();
    }

    public function testRegexIterator()
    {
        $this->coll->add('test1');
        $this->coll->add('test2');
        $this->coll->add('test3');

        $i = new RegexIterator($this->coll->getIterator(), '/^(test)(\d+)/', RegexIterator::REPLACE);
        $i->replacement = '$2:$1';
        $this->coll->setIterator($i);

        $this->assertEquals(array('1:test', '2:test', '3:test'), iterator_to_array($this->coll->getIterator()));
    }
}