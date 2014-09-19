<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Easy\Tests\Collections\Linq;

use Easy\Collections\Linq\Criteria;
use Easy\Collections\Linq\Expr\Comparison;
use Easy\Collections\Linq\Expr\CompositeExpression;
use Easy\Tests\Collections\CollectionsTestCase;

/**
 * Description of CriteiraTest
 *
 * @author italo
 */
class CriteiraTest extends CollectionsTestCase
{

    public function testCreate()
    {
        $criteria = Criteria::create();

        $this->assertInstanceOf("Easy\Collections\Linq\Criteria", $criteria);
    }

    public function testConstructor()
    {
        $expr = new Comparison("field", "=", "value");
        $criteria = new Criteria($expr, array("foo" => "ASC"), 10, 20);

        $this->assertSame($expr, $criteria->getWhereExpression());
        $this->assertEquals(array("foo" => "ASC"), $criteria->getOrderings());
        $this->assertEquals(10, $criteria->getFirstResult());
        $this->assertEquals(20, $criteria->getMaxResults());
    }

    public function testWhere()
    {
        $expr = new Comparison("field", "=", "value");
        $criteria = new Criteria();

        $criteria->where($expr);

        $this->assertSame($expr, $criteria->getWhereExpression());
    }

    public function testAndWhere()
    {
        $expr = new Comparison("field", "=", "value");
        $criteria = new Criteria();

        $criteria->where($expr);
        $expr = $criteria->getWhereExpression();
        $criteria->andWhere($expr);

        $where = $criteria->getWhereExpression();
        $this->assertInstanceOf('Easy\Collections\Linq\Expr\CompositeExpression', $where);

        $this->assertEquals(CompositeExpression::TYPE_AND, $where->getType());
        $this->assertSame(array($expr, $expr), $where->getExpressionList());
    }

    public function testOrWhere()
    {
        $expr = new Comparison("field", "=", "value");
        $criteria = new Criteria();

        $criteria->where($expr);
        $expr = $criteria->getWhereExpression();
        $criteria->orWhere($expr);

        $where = $criteria->getWhereExpression();
        $this->assertInstanceOf('Easy\Collections\Linq\Expr\CompositeExpression', $where);

        $this->assertEquals(CompositeExpression::TYPE_OR, $where->getType());
        $this->assertSame(array($expr, $expr), $where->getExpressionList());
    }

    public function testOrderings()
    {
        $criteria = Criteria::create()
                ->orderBy(array("foo" => "ASC"));

        $this->assertEquals(array("foo" => "ASC"), $criteria->getOrderings());
    }

    public function testExpr()
    {
        $this->assertInstanceOf('Easy\Collections\Linq\ExpressionBuilder', Criteria::createExpression());
    }

}
