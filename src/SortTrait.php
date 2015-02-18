<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

/**
 * Provides utility protected methods for extracting a property or column
 * from an array or object.
 */
trait SortTrait
{
    /**
     * Sorts the elements in the entire Collection<T> using the specified comparer.
     * @param ComparerInterface $comparer The ComparerInterface implementation to use when comparing elements, or null to use the default comparer Comparer<T>.Default.
     * @return $this
     */
    public function sort(ComparerInterface $comparer = null)
    {
        if ($comparer === null) {
            $comparer = $this->getDefaultComparer();
        }
        usort($this->storage, array($comparer, 'compare'));
        return $this;
    }

    /**
     * Sorts the keys in the entire Collection<T> using the specified comparer.
     * @param ComparerInterface $comparer The ComparerInterface implementation to use when comparing elements, or null to use the default comparer Comparer<T>.Default.
     * @return $this
     */
    public function sortByKey(ComparerInterface $comparer = null)
    {
        if ($comparer === null) {
            $comparer = $this->getDefaultComparer();
        }
        uksort($this->storage, array($comparer, 'compare'));
        return $this;
    }
}