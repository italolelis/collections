<?php

namespace Collections\Traits;

use Collections\Dictionary;
use Collections\Iterable;
use Collections\VectorInterface;

trait StrictIterableTrait
{
    use CommonMutableContainerTrait;

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function map(callable $callable)
    {
        $results = new static();
        /** @var Dictionary $this */
        foreach ($this as $element) {
            $results[] = $callable($element);
        }

        return $results;
    }

    /**
     * {@inheritDoc}
     * @return VectorInterface
     */
    public function filter(callable $callable)
    {
        /** @var VectorInterface $results */
        $results = new static();
        foreach ($this as $element) {
            if ($callable($element)) {
                $results[] = $element;
            }
        }

        return $results;
    }

    /**
     * {@inheritDoc}
     * @return VectorInterface
     */
    public function zip(Iterable $iterable)
    {
        /** @var VectorInterface $results */
        $results = new static();
        /** @var \Iterator $iterator */
        $iterator = $iterable->getIterator();
        foreach ($this as $element) {
            if (!$iterator->valid()) {
                break;
            }
            $results[] = new Pair($element, $iterator->current());
            $iterator->next();
        }

        return $results;
    }

    /**
     * {@inheritDoc}
     * @return VectorInterface
     */
    public function take($size = 1)
    {
        /** @var VectorInterface $results */
        $results = new static();

        if ($size <= 0) {
            return $results;
        }
        /** @var Dictionary $this */
        foreach ($this as $element) {
            $results[] = $element;
            if (--$size === 0) {
                break;
            }
        }

        return $results;
    }

    /**
     * {@inheritDoc}
     * @return VectorInterface
     */
    public function takeWhile(callable $callable)
    {
        /** @var VectorInterface $results */
        $results = new static();
        /** @var Dictionary $this */
        foreach ($this as $element) {
            if (!$callable($element)) {
                break;
            }
            $results[] = $element;
        }

        return $results;
    }

    /**
     * {@inheritDoc}
     * @return VectorInterface
     */
    public function skip($n)
    {
        /** @var VectorInterface $results */
        $results = new static();
        /** @var Dictionary $this */
        foreach ($this as $element) {
            if ($n <= 0) {
                $results[] = $element;
            } else {
                --$n;
            }
        }

        return $results;
    }

    /**
     * {@inheritDoc}
     * @return VectorInterface
     */
    public function skipWhile(callable $callable)
    {
        /** @var VectorInterface $results */
        $results = new static();
        $skip = true;
        /** @var Dictionary $this */
        foreach ($this as $element) {
            if ($skip) {
                if ($callable($element)) {
                    continue;
                }
                $skip = false;
            }
            $results[] = $element;
        }

        return $results;
    }

    /**
     * {@inheritDoc}
     * @return VectorInterface
     */
    public function slice($start, $length)
    {
        /** @var VectorInterface $results */
        $results = new static();

        if ($length <= 0) {
            return $results;
        }
        /** @var Dictionary $this */
        foreach ($this as $element) {
            if ($start !== 0) {
                --$start;
                continue;
            }
            $results[] = $element;
            if (--$length === 0) {
                break;
            }
        }

        return $results;
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function concat(\Traversable $iterable)
    {
        $results = [];
        /** @var Dictionary $this */
        foreach ($this as $element) {
            $results[] = $element;
        }

        foreach ($iterable as $element) {
            $results[] = $element;
        }
        $this->setAll($results);

        return $this;
    }

    /**
     * {@inheritDoc}
     * @return $this
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
     * {@inheritDoc}
     * @return $this
     */
    public function last()
    {
        $results = $this->toArray();

        return array_pop($results);
    }

    /**
     * {@inheritDoc}
     * @return $this
     */
    public function each(callable $callable)
    {
        /** @var Dictionary $this */
        foreach ($this as $element) {
            $callable($element);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     * @return bool
     */
    public function exists(callable $callable)
    {
        /** @var Dictionary $this */
        foreach ($this as $element) {
            if ($callable($element)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return VectorInterface
     */
    public function concatAll()
    {
        /** @var VectorInterface $results */
        $results = new static();
        $this->each(function (Iterable $subArray) use ($results) {
            $subArray->each(function ($item) use ($results) {
                $results->add($item);
            });
        });

        return $results;
    }
}
