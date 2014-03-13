<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Easy\Collections\Test;

/**
 * Description of Collection
 *
 * @author italo
 */
abstract class CollectionsTestCase extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidElementsToInstanciate()
    {
        $coll = new \Easy\Collections\ArrayList();
        $coll->addAll('string');
    }

}
