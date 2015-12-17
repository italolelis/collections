<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

use Collections\Immutable\ImmArrayList;
use Collections\Immutable\ImmDictionary;
use Collections\Immutable\ImmSet;
use Rx\Observable\ArrayObservable;
use Rx\Observable\BaseObservable;

/**
 * Provides the abstract base class for a strongly typed collection.
 */
abstract class AbstractConstCollectionArray extends AbstractCollection implements
    ConstIndexAccessInterface,
    CollectionConvertableInterface,
    \Serializable,
    \JsonSerializable
{

    use SortTrait;

    /**
     * @var array
     */
    protected $container = [];

    /**
     * AbstractConstCollectionArray constructor.
     *
     * @param mixed $array
     *
     * @throws  \InvalidArgumentException
     */
    public function __construct($array = null)
    {
        if ($array !== null) {
            if (!is_array($array) && !$array instanceof \Traversable) {
                throw new \InvalidArgumentException('Parameter must be an array or an instance of Traversable');
            }

            foreach ($array as $key => $item) {
                if (is_array($item)) {
                    $item = new static($item);
                }
                $this[$key] = $item;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty()
    {
        return $this->count() === 0;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->container);
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->container = [];

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize($this->container);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $this->container = unserialize($serialized);

        return $this->container;
    }

    /**
     * {@inheritdoc}
     */
    public function tryGet($index, $default = null)
    {
        if ($this->containsKey($index) === false) {
            return $default;
        }

        return $this->get($index);
    }

    /**
     * @return BaseObservable
     */
    public function toObservable()
    {
        return new ArrayObservable($this->toArray());
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
        return $this->container;
    }

    /**
     * @return ArrayList
     */
    public function toVector()
    {
        return new ArrayList($this);
    }

    /**
     * @return ImmArrayList
     */
    public function toImmVector()
    {
        return new ImmArrayList($this);
    }

    /**
     * TODO: Implement toSet() method.
     */
    public function toSet()
    {
    }

    /**
     * @return ImmSet
     */
    public function toImmSet()
    {
        return new ImmSet($this);
    }

    /**
     * @return LazyIterableView
     */
    public function lazy()
    {
        return new LazyIterableView($this);
    }

    /**
     * @return Dictionary
     */
    public function toMap()
    {
        return new Dictionary($this);
    }

    /**
     * @return ImmDictionary
     */
    public function toImmMap()
    {
        return new ImmDictionary($this);
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->container;
    }
}
