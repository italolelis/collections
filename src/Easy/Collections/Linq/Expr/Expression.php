<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.

namespace Easy\Collections\Linq\Expr;

/**
 * Expression for the {@link Selectable} interface.
 *
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 */
interface Expression
{

    /**
     * @param ExpressionVisitor $visitor
     *
     * @return mixed
     */
    public function visit(ExpressionVisitor $visitor);
}