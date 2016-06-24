<?php

namespace Collections;

use Collections\Iterator\SetIterator;
use Collections\Traits\SetLikeTrait;

/**
 * Set is an ordered set-style collection.
 *
 * Like all objects in PHP, Sets have reference-like semantics. When a caller
 * passes a Set to a callee, the callee can modify the Set and the caller will
 * see the changes. Sets do not have "copy-on-write" semantics.
 *
 * Sets preserve insertion order of the elements. When iterating over a Set,
 * the elements appear in the order they were inserted. Also, Sets do not
 * automagically convert integer-like strings (ex. "123") into integers.
 *
 * Sets only support integer values and string values. If a value of a
 * different type is used, an exception will be thrown.
 *
 * In general, Sets do not support "$c[$k]" style syntax. Adding an element
 * using "$c[] = .." syntax is supported.
 *
 * Set do not support iteration while elements are being added or removed.
 * When an element is added or removed, all iterators that point to the Set
 * shall be considered invalid.
 *
 * Sets do not support taking elements by reference. If binding assignment (=&)
 * is used when adding a new element to a Set (ex. "$c[] =& ..."), or if a Set
 * is used with foreach by reference, an exception will be thrown.
 */
class Set implements SetInterface, \ArrayAccess
{
    use SetLikeTrait;

    public function __construct($array = null)
    {
        $this->init($array);
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new SetIterator($this->container);
    }
}
