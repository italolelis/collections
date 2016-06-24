<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

use Collections\Exception\InvalidOperationException;
use Collections\Iterator\PairIterator;
use Collections\Traits\ImmVectorLikeTrait;

/**
 * `Pair` is a fixed-size collection with exactly two elements (possibly of
 * different types). HHVM provides a native implementation for this class.
 * The PHP class definition below is not actually used at run time; it is
 * simply provided for the typechecker and for developer reference.
 *
 * Like all objects in PHP, `Pair`s have reference-like semantics. The elements
 * or a `Pair` cannot be mutated (i.e. you can assign to the elements of a
 * `Pair`) though `Pair`s may contain mutable objects.
 *
 * `Pair`s only support integer keys. If a non-integer key is used, an
 * exception will be thrown.
 *
 * `Pair`s support `$m[$k]` style syntax for getting and setting values by
 * key. `Pair`s also support `isset($m[$k])` and `empty($m[$k])` syntax, and
 * they provide similar semantics as arrays. Elements can be added to a `Pair`
 * using `$m[] = ..` syntax.
 *
 * `Pair`s do not support taking elements by reference. If binding assignment
 * (`=&`) is used with an element of a `Pair`, or if an element of a `Pair` is
 * passed by reference, of if a `Pair` is used with foreach by reference, an
 * exception will be thrown.
 *
 * `Pair` keys are always 0 and 1, repsectively.
 *
 * You may notice that many methods affecting the instace of `Pair` return an
 * `ImmVector` -- `Pair`s are essentially backed by 2-element `ImmVector`s.
 *
 */
final class Pair implements ConstVectorInterface, \ArrayAccess
{
    use ImmVectorLikeTrait;

    /**
     * Pair constructor.
     * @param $item1
     * @param $item2
     */
    public function __construct($item1, $item2)
    {
        $this->container[] = $item1;
        $this->container[] = $item2;
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        return new PairIterator($this->container);
    }

    /**
     * Returns `false`; a `Pair` cannot be empty.
     * @return bool - `false`
     */
    public function isEmpty()
    {
        return false;
    }

    /**
     * Returns 2; a `Pair` always has two values.
     * @return int
     */
    public function count()
    {
        return 2;
    }

    /**
     * @internal
     */
    public function __get($name)
    {
        throw InvalidOperationException::unsupportedGet($this);
    }

    /**
     * @internal
     */
    public function __set($name, $value)
    {
        throw InvalidOperationException::unsupportedSet($this);
    }

    /**
     * @internal
     */
    public function __isset($name)
    {
        return false;
    }

    /**
     * @internal
     */
    public function __unset($name)
    {
        throw InvalidOperationException::unsupportedUnset($this);
    }
}
