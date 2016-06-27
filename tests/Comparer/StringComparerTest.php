<?php

namespace Tests\Collections\Comparer;

use Collections\Comparer\StringComparer;

class StringComparerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_compare_two_strings()
    {
        $comparer = new StringComparer();
        $result = $comparer->compare("test", "amazing");

        $this->assertInternalType("int", $result);
    }
}
