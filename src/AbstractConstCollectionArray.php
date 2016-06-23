<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

use Collections\Immutable\ImmArrayList;
use Collections\Immutable\ImmDictionary;
use Collections\Immutable\ImmSet;

/**
 * Provides the abstract base class for a strongly typed collection.
 */
abstract class AbstractConstCollectionArray extends AbstractCollection implements
    CollectionInterface,
    CollectionConvertableInterface,
    \Serializable,
    \JsonSerializable
{
    use SortTrait;

    public function __construct($array = null)
    {
        if ($array !== null) {
            $this->addAll($array);
        }
    }

    /**
     * @var array
     */
    protected $container = [];

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
    public function jsonSerialize()
    {
        return $this->container;
    }

    /**
     * {@inheritdoc}
     */
    public function toVector()
    {
        return new ArrayList($this);
    }

    /**
     * {@inheritdoc}
     */
    public function toImmVector()
    {
        return new ImmArrayList($this);
    }

    /**
     * {@inheritdoc}
     */
    public function toSet()
    {
        return new Set($this);
    }

    /**
     * {@inheritdoc}
     */
    public function toImmSet()
    {
        return new ImmSet($this);
    }

    /**
     * {@inheritdoc}
     */
    public function toMap()
    {
        return new Dictionary($this);
    }

    /**
     * {@inheritdoc}
     */
    public function toImmMap()
    {
        return new ImmDictionary($this);
    }
}
