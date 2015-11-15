<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

use Closure;
use Collections\Immutable\ImmArrayList;
use Collections\Immutable\ImmDictionary;
use Collections\Immutable\ImmSet;
use Collections\Rx\ReactiveExtensionInterface;
use Collections\Rx\RxTrait;
use Rx\Observable\ArrayObservable;
use Rx\ObservableInterface;

/**
 * Provides the abstract base class for a strongly typed collection.
 */
abstract class AbstractCollectionArray extends AbstractCollection implements
    CollectionInterface,
    IndexAccessInterface,
    ReactiveExtensionInterface,
    ConstIndexAccessInterface,
    CollectionConvertableInterface,
    \Serializable,
    \JsonSerializable
{

    use
        RxTrait,
        SortTrait;

    /**
     * @var array
     */
    protected $container = [];

    public function __construct($array = null)
    {
        if ($array !== null) {
            $this->addAll($array);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setAll($items)
    {
        if (!is_array($items) && !$items instanceof \Traversable) {
            throw new \InvalidArgumentException('Parameter must be an array or an instance of Traversable');
        }

        foreach ($items as $key => $item) {
            if (is_array($item)) {
                $item = new static($item);
            }
            $this->set($key, $item);
        }

        return $this;
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
    public function values()
    {
        return $this->toValuesArray();
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
     * {@inheritdoc}
     */
    public function exists(Closure $closure)
    {
        foreach ($this->container as $key => $element) {
            if ($closure($key, $element)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return ObservableInterface
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

    public function toValuesArray()
    {
        return array_values($this->container);
    }

    public function toKeysArray()
    {
        return array_keys($this->container);
    }

    public function toVector()
    {
        return new ArrayList($this);
    }

    public function toImmVector()
    {
        return new ImmArrayList($this);
    }

    public function toSet()
    {
        // TODO: Implement toSet() method.
    }

    public function toImmSet()
    {
        return new ImmSet($this);
    }

    public function lazy()
    {
        return new LazyIterableView($this);
    }

    public function toMap()
    {
        return new Dictionary($this);
    }

    public function toImmMap()
    {
        return new ImmDictionary($this);
    }
}
