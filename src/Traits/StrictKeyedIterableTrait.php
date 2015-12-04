<?php

namespace Collections\Traits;

use Collections\ArrayList;
use Collections\Dictionary;
use Collections\Iterable;
use Collections\MapInterface;

trait StrictKeyedIterableTrait
{
    use CommonMutableContainerTrait;

    /**
     * @return ArrayList
     */
    public function keys()
    {
        $results = new ArrayList();
        /** @var Dictionary $this */
        foreach ($this as $key => $nulled) {
            $results[] = $key;
        }

        return $results;
    }

    /**
     * @param callable $callback
     *
     * @return Dictionary
     */
    public function map(callable $callback)
    {
        $results = new Dictionary();
        /** @var Dictionary $this */
        foreach ($this as $key => $element) {
            $results[$key] = $callback($element);
        }

        return $results;
    }

    /**
     * @param callable $callback
     *
     * @return Dictionary
     */
    public function mapWithKey(callable $callback)
    {
        $results = new Dictionary();
        /** @var Dictionary $this */
        foreach ($this as $key => $element) {
            $results[$key] = $callback($key, $element);
        }

        return $results;
    }

    /**
     * @param callable $callback
     *
     * @return Dictionary
     */
    public function filter(callable $callback)
    {
        $results = new Dictionary();
        /** @var Dictionary $this */
        foreach ($this as $key => $element) {
            if ($callback($element)) {
                $results[$key] = $element;
            }
        }

        return $results;
    }

    /**
     * @param callable $callback
     *
     * @return Dictionary
     */
    public function filterWithKey(callable $callback)
    {
        $results = new Dictionary();
        /** @var Dictionary $this */
        foreach ($this as $key => $element) {
            if ($callback($key, $element)) {
                $results[$key] = $element;
            }
        }

        return $results;
    }

    /**
     * @param Dictionary $iterable
     *
     * @return Dictionary
     */
    public function zip(Dictionary $iterable)
    {
        $results = new Dictionary();
        $it = $iterable->getIterator();
        /** @var Dictionary $this */
        foreach ($this as $key => $element) {
            if (!$it->valid()) {
                break;
            }
            $results[$key] = new Pair($element, $it->current());
            $it->next();
        }

        return $results;
    }

    /**
     * @param int $size
     *
     * @return Dictionary
     */
    public function take($size = 1)
    {
        $results = new Dictionary();
        if ($size <= 0) {
            return $results;
        }
        /** @var Dictionary $this */
        foreach ($this as $key => $element) {
            $results[$key] = $element;
            if (--$size === 0) {
                break;
            }
        }

        return $results;
    }

    /**
     * @param callable $callback
     *
     * @return Dictionary
     */
    public function takeWhile(callable $callback)
    {
        $results = new Dictionary();
        /** @var Dictionary $this */
        foreach ($this as $key => $element) {
            if (!$callback($element)) {
                break;
            }
            $results[$key] = $element;
        }

        return $results;
    }

    /**
     * @param int $count
     *
     * @return Dictionary
     */
    public function skip($count)
    {
        $results = new Dictionary();
        /** @var Dictionary $this */
        foreach ($this as $key => $element) {
            if ($count <= 0) {
                $results[$key] = $element;
            } else {
                --$count;
            }
        }

        return $results;
    }

    /**
     * @param callable $callback
     *
     * @return Dictionary
     */
    public function skipWhile(callable $callback)
    {
        $results = new Dictionary();
        $skip = true;
        /** @var Dictionary $this */
        foreach ($this as $key => $element) {
            if ($skip) {
                if ($callback($element)) {
                    continue;
                }
                $skip = false;
            }
            $results[$key] = $element;
        }

        return $results;
    }

    /**
     * @param int $start
     * @param int $length
     *
     * @return Dictionary
     */
    public function slice($start, $length)
    {
        $results = new Dictionary();
        if ($length <= 0) {
            return $results;
        }
        /** @var Dictionary $this */
        foreach ($this as $key => $element) {
            if ($start !== 0) {
                --$start;
                continue;
            }
            $results[$key] = $element;
            if (--$length === 0) {
                break;
            }
        }

        return $results;
    }

    /**
     * @param \Traversable $iterable
     *
     * @return Dictionary
     */
    public function concat(\Traversable $iterable)
    {
        $results = [];
        /** @var Dictionary $this */
        foreach ($this as $key => $element) {
            $results[$key] = $element;
        }

        foreach ($iterable as $key => $element) {
            $results[$key] = $element;
        }
        $this->setAll($results);

        return $this;
    }

    /**
     * @return mixed|null
     */
    public function first()
    {
        /** @var Dictionary $this */
        foreach ($this as $element) {
            return $element;
        }

        return null;
    }

    /**
     * @return int|null|string
     */
    public function firstKey()
    {
        /** @var Dictionary $this */
        foreach ($this as $key => $nulled) {
            return $key;
        }

        return null;
    }

    /**
     * @return mixed|null
     */
    public function last()
    {
        $element = null;
        /** @var Dictionary $this */
        foreach ($this as $element) {
        }

        return $element;
    }

    /**
     * @return int|null|string
     */
    public function lastKey()
    {
        $key = null;
        /** @var Dictionary $this */
        foreach ($this as $key => $nulled) {
        }

        return $key;
    }

    /**
     * @param callable $callback
     *
     * @return Dictionary
     */
    public function each(callable $callback)
    {
        /** @var Dictionary $this */
        foreach ($this as $key => $element) {
            $callback($element, $key);
        }

        return $this;
    }

    /**
     * @param callable $callback
     *
     * @return bool
     */
    public function exists(callable $callback)
    {
        /** @var Dictionary $this */
        foreach ($this as $key => $element) {
            if ($callback($key, $element)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return MapInterface
     */
    public function concatAll()
    {
        /** @var MapInterface $results */
        $results = new static();
        $this->each(function (Iterable $subArray) use ($results) {
            $subArray->each(function ($item, $key) use ($results) {
                $results->add($key, $item);
            });
        });

        return $results;
    }
}
