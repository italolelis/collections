<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections\Iterator;

use IteratorIterator;
use Traversable;

/**
 * Creates an iterator from another iterator that extract the requested column
 * or property based on a path
 */
class ExtractIterator extends IteratorIterator
{
    /**
     * A callable responsible for extracting a single value for each
     * item in the collection.
     *
     * @var callable
     */
    protected $extractor;

    /**
     * Creates the iterator that will return the requested property for each value
     * in the collection expressed in $path
     *
     * ### Example:
     *
     * Extract the user name for all comments in the array:
     *
     * ```
     * $items = [
     *  ['comment' => ['body' => 'cool', 'user' => ['name' => 'Mark']],
     *  ['comment' => ['body' => 'very cool', 'user' => ['name' => 'Renan']]
     * ];
     * $extractor = new ExtractIterator($items, 'comment.user.name'');
     * ```
     *
     * @param array|\Traversable $items The list of values to iterate
     * @param string $path a dot separated string symbolizing the path to follow
     * inside the hierarchy of each value so that the column can be extracted.
     */
    public function __construct($items, $path)
    {
        $this->extractor = $items->propertyExtractor($path);
        parent::__construct($items);
    }

    /**
     * Returns the column value defined in $path or null if the path could not be
     * followed
     *
     * @return mixed
     */
    public function current()
    {
        $extractor = $this->extractor;
        return $extractor(parent::current());
    }
}