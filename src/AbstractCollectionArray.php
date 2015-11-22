<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

/**
 * Provides the abstract base class for a strongly typed collection.
 */
abstract class AbstractCollectionArray extends AbstractConstCollectionArray implements
    CollectionInterface,
    IndexAccessInterface,
    ConstIndexAccessInterface,
    CollectionConvertableInterface,
    \Serializable,
    \JsonSerializable
{
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
    public function clear()
    {
        $this->container = [];

        return $this;
    }
}
