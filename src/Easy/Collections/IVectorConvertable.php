<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Easy\Collections;

/**
 * Provides functionality to convert the collection into any IList
 */
interface IVectorConvertable extends ICollectionConvertable
{

    /**
     * Returns a Map of the ICollection, with the integer indicies of the 
     * ICollection as the keys and the values of the ICollection as the values.
     * @return IMap
     */
    public function toMap();
}