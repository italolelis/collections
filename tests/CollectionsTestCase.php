<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Easy\Tests\Collections;

use PHPUnit_Framework_TestCase;

/**
 * Description of Collection
 *
 * @author italo
 */
abstract class CollectionsTestCase extends PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        date_default_timezone_set('America/Recife');
    }

}
