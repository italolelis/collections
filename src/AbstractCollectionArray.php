<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

use Closure;
use Collections\Iterator\ArrayIterator;
use Collections\Rx\ReactiveExtensionInterface;
use Collections\Rx\RxTrait;

/**
 * Provides the abstract base class for a strongly typed collection.
 */
abstract class AbstractCollectionArray extends AbstractCollection implements
    IndexAccessInterface,
    ConstIndexAccessInterface,
    ReactiveExtensionInterface,
    CollectionConvertableInterface,
    \JsonSerializable
{

    use RxTrait,
        SortTrait;
    /**
     * @var array
     */
    protected $storage = [];

    public function __construct($array = null)
    {
        if ($array !== null) {
            $this->addAll($array);
        }
    }

    /**
     * Gets the collection's iterator
     * @return \Iterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->storage);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->storage);
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->storage = [];
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty()
    {
        return $this->count() < 1;
    }

    /**
     * {@inheritdoc}
     */
    public function values()
    {
        return array_values($this->storage);
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize($this->storage);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $this->storage = unserialize($serialized);
        return $this->storage;
    }

    /**
     * {@inheritdoc}
     */
    public function concat(CollectionConvertableInterface $collection)
    {
        $this->storage = array_merge($this->storage, $collection->toArray());
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function containsKey($key)
    {
        return $this->offsetExists($key);
    }

    /**
     * {@inheritdoc}
     */
    public function contains($element)
    {
        return in_array($element, $this->storage, true);
    }

    /**
     * {@inheritdoc}
     */
    public function get($index)
    {
        return $this->offsetGet($index);
    }

    /**
     * {@inheritdoc}
     * @param string $default
     */
    public function tryGet($index, $default = null)
    {
        if ($this->containsKey($index) === false) {
            return $default;
        }

        return $this->get($index);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($index)
    {
        $this->offsetUnset($index);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeValue($element)
    {
        $key = array_search($element, $this->storage, true);

        if ($key !== false) {
            $this->offsetUnset($key);
            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function exists(Closure $closure)
    {
        foreach ($this->storage as $key => $element) {
            if ($closure($key, $element)) {
                return true;
            }
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function toKeysArrays()
    {
        return $this->getIterator()->keys()->toArray();
    }

    public function toArray()
    {
        return $this->getIterator()->toArray();
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return $this->storage;
    }
}
