<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections;

/**
 * Represents a write-enabled (mutable) sequence of key/value pairs
 * (i.e. a map).
 */
interface MapInterface extends
    ConstMapInterface,
    CollectionInterface,
    MapAccessInterface
{

}
