<?php

namespace Tests\Collections\Iterator;

use Tests\Collections\CollectionsTestCase;

class CollectionTestDriver extends CollectionsTestCase
{

    /**
     * @param \Iterator $collection
     * @param callable $add This callable will add an item to $collection.
     */
    public function doMapTests(\Iterator $collection, callable $add)
    {
        $add(0);
        $add(1);
        $add(2);
        $add(3);

        $a = $collection->map(function ($value, $key) {
            return [$value * 2, $key];
        });

        $this->assertCount(4, $a);

        $expect = [0, 2, 4, 6];
        foreach ($a as $key => $value) {
            $this->assertEquals($expect[$key], $value[0]);
        }
    }


    /**
     * @param \Iterator $collection
     * @param callable $add This callable will add an item to $collection.
     */
    public function doSliceTests(\Iterator $collection, callable $add)
    {

        $add(0);
        $add(1);
        $add(2);
        $add(3);


        $a = $collection->slice(0, 0);
        $this->assertCount(0, $a);


        $b = $collection->slice(0, 2);
        $this->assertCount(2, $b);
        $expect = [0, 1];
        foreach ($b as $key => $value) {
            $this->assertEquals($expect[$key], $value);
        }


        $c = $collection->slice(1, 2);
        $this->assertCount(2, $c);
        $expect = [1 => 1, 2 => 2];
        foreach ($c as $key => $value) {
            $this->assertEquals($expect[$key], $value);
        }


        $d = $collection->slice(0, 6);
        $this->assertCount(4, $d);
        $expect = [0, 1, 2, 3];
        foreach ($d as $key => $value) {
            $this->assertEquals($expect[$key], $value);
        }


        $e = $collection->slice(4, 1);
        $this->assertCount(0, $e);
    }

}