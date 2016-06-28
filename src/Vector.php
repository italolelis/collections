<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

use Collections\Iterator\VectorIterator;
use Collections\Traits\VectorLikeTrait;

/**
 * Vector is a stack-like collection.
 *
 * Like all objects in PHP, Vectors have reference-like semantics. When a
 * caller passes a Vector to a callee, the callee can modify the Vector and the
 * caller will see the changes. Vectors do not have "copy-on-write" semantics.
 *
 * Vectors only support integer keys. If a non-integer key is used, an
 * exception will be thrown.
 *
 * Vectors suoport "$m[$k]" style syntax for getting and setting values by
 * key. Vectors also support "isset($m[$k])" and "empty($m[$k])" syntax, and
 * they provide similar semantics as arrays. Elements can be added to a Vector
 * using "$m[] = .." syntax.
 *
 * Vectors do not support iterating while new elements are being added or
 * elements are being removed. When a new element is added or removed, all
 * iterators that point to the Vector shall be considered invalid.
 *
 * Vectors do not support taking elements by reference. If binding assignment
 * (=&) is used with an element of a Vector, or if an element of a Vector is
 * passed by reference, of if a Vector is used with foreach by reference, an
 * exception will be thrown.
 */
class Vector implements VectorInterface, \ArrayAccess, \JsonSerializable, \Serializable
{
    use VectorLikeTrait, SortTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct($array = null)
    {
        $this->init($array);
    }

    public static function fromItems($items)
    {
        return new self($items);
    }

    /**
     * {@inheritdoc}
     */
    public function indexOf($item)
    {
        return array_search($item, $this->container, true);
    }

    /**
     * {@inheritdoc}
     */
    public function reverse()
    {
        return static::fromArray(array_reverse($this->container));
    }

    /**
     * Gets the collection's iterator
     * @return VectorIterator
     */
    public function getIterator()
    {
        return new VectorIterator($this->container);
    }
}
