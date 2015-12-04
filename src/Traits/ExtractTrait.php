<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections\Traits;

use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Provides utility protected methods for extracting a property or column
 * from an array or object.
 */
trait ExtractTrait
{
    /**
     * Returns a callable that can be used to extract a property or column from
     * an array or object based on a dot separated path.
     *
     * @param string|callable $callback A dot separated path of column to follow
     *                                  so that the final one can be returned or a callable that will take care
     *                                  of doing that.
     *
     * @return callable
     */
    public function propertyExtractor($callback)
    {
        if (is_string($callback)) {
            $path = explode('.', $callback);
            $callback = function ($element) use ($path) {
                return $this->extractData($element, $path);
            };
        }

        return $callback;
    }

    /**
     * Returns a column from $data that can be extracted
     * by iterating over the column names contained in $path
     *
     * @param array|\ArrayAccess $data Data.
     * @param array              $path Path to extract from.
     *
     * @return mixed
     */
    protected function extractData($data, $path)
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        $value = null;
        foreach ($path as $column) {
            if (is_array($data) || $data instanceof \ArrayAccess) {
                $value = $accessor->getValue($data, "[$column]");
            } else {
                if (!$accessor->isReadable($data, $column)) {
                    return null;
                }

                $value = $accessor->getValue($data, $column);
            }
            $data = $value;
        }

        return $value;
    }

    /**
     * Returns a callable that receives a value and will return whether or not
     * it matches certain condition.
     *
     * @param array $conditions A key-value list of conditions to match where the
     *                          key is the property path to get from the current item and the value is the
     *                          value to be compared the item with.
     *
     * @return callable
     */
    protected function createMatcherFilter(array $conditions)
    {
        $matchers = [];
        foreach ($conditions as $property => $value) {
            $extractor = $this->propertyExtractor($property);
            $matchers[] = function ($v) use ($extractor, $value) {
                return $extractor($v) == $value;
            };
        }

        return function ($value) use ($matchers) {
            foreach ($matchers as $match) {
                if (!$match($value)) {
                    return false;
                }
            }

            return true;
        };
    }
}
