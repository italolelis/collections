<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

use Collections\Comparer\NumericKeyComparer;
use Collections\Generic\ComparerInterface;
use Easy\Generics\EquatableInterface;
use Rx\Observable\ArrayObservable;
use Rx\ObservableInterface;

/**
 * Provides the abstract base class for a strongly typed collection.
 */
abstract class AbstractCollection implements CollectionInterface, EquatableInterface
{
    /**
     * @var ComparerInterface
     */
    private $defaultComparer;

    /**
     * Gets the default comparer for this collection
     * @return ComparerInterface
     */
    public function getDefaultComparer()
    {
        if ($this->defaultComparer === null) {
            $this->defaultComparer = new NumericKeyComparer();
        }

        return $this->defaultComparer;
    }

    /**
     * Sets the default comparer for this collection
     * @param ComparerInterface $defaultComparer
     * @return CollectionInterface
     */
    public function setDefaultComparer(ComparerInterface $defaultComparer)
    {
        $this->defaultComparer = $defaultComparer;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return get_class($this);
    }

    public function equals($obj)
    {
        return ($obj === $this);
    }
}
