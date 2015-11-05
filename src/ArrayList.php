<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

use InvalidArgumentException;
use Rx\Observable\ArrayObservable;
use Rx\ObservableInterface;
use Traversable;

/**
 * Represents a strongly typed list of objects that can be accessed by index. Provides methods to search, sort,
 * and manipulate lists.
 */
class ArrayList extends AbstractCollectionArray implements VectorInterface, VectorConvertableInterface
{
    use GuardTrait;

    /**
     * {@inheritdoc}
     */
    public function add($item)
    {
        $this->storage[] = $item;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addAll($items)
    {
        if (!is_array($items) && !$items instanceof Traversable) {
            throw new \InvalidArgumentException('The items must be an array or Traversable');
        }

        foreach ($items as $item) {
            if (is_array($item)) {
                $item = static::fromArray($item);
            }
            $this->add($item);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function indexOf($item)
    {
        return array_search($item, $this->storage, true);
    }

    /**
     * {@inheritdoc}
     */
    public function insert($index, $item)
    {
        if (!is_numeric($index)) {
            throw new InvalidArgumentException('The index must be numeric');
        }
        if ($index < 0 || $index >= $this->count()) {
            throw new InvalidArgumentException('The index is out of bounds (must be >=0 and <= size of te array)');
        }

        $current = $this->count() - 1;
        for (; $current >= $index; $current--) {
            $this->storage[$current + 1] = $this->storage[$current];
        }
        $this->storage[$index] = $item;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        $offset = $this->intGuard($offset);

        return array_key_exists((int)$offset, $this->storage);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        $offset = $this->existsGuard($this->intGuard($offset));

        return $this->storage[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $offset = $this->intGuard($offset);
        if ($offset < 0) {
            throw new InvalidArgumentException('The option value must be a number > 0');
        }
        $this->storage[(int)$offset] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        $offset = $this->intGuard($offset);

        if ($this->containsKey($offset) === false) {
            throw new InvalidArgumentException('The key ' . $offset . ' is not present in the collection');
        }

        unset($this->storage[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function toMap()
    {
        return new Dictionary($this->getIterator());
    }

    /**
     * {@inheritdoc}
     */
    public function reverse()
    {
        return static::fromArray(array_reverse($this->storage));
    }

    /**
     * {@inheritdoc}
     */
    public function splice($offset, $length = null)
    {
        return static::fromArray(array_splice($this->storage, $offset, $length));
    }

    /**
     * {@inheritdoc}
     */
    public static function fromArray(array $arr)
    {
        $map = new ArrayList();
        foreach ($arr as $v) {
            if (is_array($v)) {
                $map->add(new ArrayList($v));
            } else {
                $map->add($v);
            }
        }

        return $map;
    }
}
