<?php

namespace Easy\Tests\Collections;

use Easy\Collections\ArrayList;

class RxTest extends CollectionsTestCase
{
    /**
     * @var ArrayList
     */
    private $coll;

    protected function setUp()
    {
        $this->coll = new ArrayList();
    }

    public function testFlatMapWithValues()
    {
        $arrayList = new ArrayList(array(0, 1, 2, 3, 4, 5));
        $newCollection = $arrayList->flatMap(function ($x) {
            return array($x, $x + 1);
        });

        $this->assertEquals(array(0, 1, 1, 2, 2, 3, 3, 4, 4, 5, 5, 6), $newCollection->toArray());
    }

}