<?php

namespace Tests\Collections\Comparer;

use Collections\Comparer\NumericKeyComparer;

class NumericKeyComparerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_compare_two_strings()
    {
        $comparer = new NumericKeyComparer();
        $result = $comparer->compare(3, 2);

        $this->assertInternalType("int", $result);
        $this->assertSame(-1, $result);
    }
}