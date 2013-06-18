<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections;

use ArrayIterator;
use Easy\Generics\EquatableInterface;

abstract class Enumerable implements EnumerableInterface
{

    protected $array = array();

    /**
     * @inheritdoc
     */
    public function getArray()
    {
        return $this->array;
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->array);
    }

    public function printCollection($UseVarDump = false)
    {
        echo "<pre>";
        if ($UseVarDump)
            var_dump($this->array);
        else
            print_r($this->array);
        echo "</pre>";
    }

    protected function itemExists($item, $array)
    {
        $result = false;
        if ($item instanceof EquatableInterface) {
            foreach ($array as $v) {
                if ($item->equals($v)) {
                    $result = true;
                    break;
                }
            }
        } elseif (in_array($item, $array, true)) {
            $result = in_array($item, $array);
        } else {
            $result = isset($array[$item]);
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function serialize()
    {
        
    }

    /**
     * @inheritdoc
     */
    public function unserialize($serialized)
    {
        
    }

}