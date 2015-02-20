<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Collections\Generic;

/**
 * The IComparer<T> type exposes the following members.
 *
 * @since 2.1.0
 * @author Ítalo Lelis de Vietro <italolelis@lellysinformatica.com>
 */
interface ComparerInterface
{

    /**
     * Compares two objects and returns a value indicating whether one is less than, equal to, or greater
     * than the other.
     * @param object $first The first object to compare.
     * @param object $second The second object to compare.
     * @return int A int that indicates the relative values of x and y, as shown in the following table.
     */
    public function compare($first, $second);
}
