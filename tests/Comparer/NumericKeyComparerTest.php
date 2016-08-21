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
    }

    /**
     * @test
     */
    public function first_is_less_than_second()
    {
        $comparer = new NumericKeyComparer();
        $result = $comparer->compare(2,3);

        $this->assertSame($result,1);
    }

    /**
     * @test
     */
    public function first_equals_second()
    {
        $comparer = new NumericKeyComparer();
        $result = $comparer->compare(2,2);

        $this->assertSame($result,0);
    }
}
