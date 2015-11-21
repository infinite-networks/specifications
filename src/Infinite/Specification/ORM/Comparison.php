<?php

/**
 * This file is part of the specifications project.
 *
 * (c) Infinite Networks Pty Ltd <http://www.infinite.net.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Infinite\Specification\ORM;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

abstract class Comparison implements Specification
{
    /**
     * @var string
     */
    private $property;

    /**
     * Indicates if a parameter should be used for the supplied $value. Can cause SQL
     * injection attacks if misused!
     *
     * @var bool
     */
    private $useParameter;

    /**
     * @var mixed
     */
    private $value;

    public function __construct($property, $value, $useParameter = true)
    {
        $this->property = $property;
        $this->useParameter = $useParameter;
        $this->value = $value;
    }

    /**
     * Should return an expression to be used for the comparison.
     *
     * @param QueryBuilder $qb
     * @param string $x
     * @param string $y
     * @return Query\Expr
     */
    abstract protected function getExpression(QueryBuilder $qb, $x, $y);

    /**
     * Adds conditions to the query builder related to the specification. The
     * specification should add parameters as required and return the expression to be
     * added to the QueryBuilder.
     *
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @param string $dqlAlias
     * @return \Doctrine\ORM\Query\Expr|null
     */
    public function match(QueryBuilder $qb, $dqlAlias)
    {
        if ($this->useParameter) {
            $parameter = sprintf('%s_%s_%s', $dqlAlias, $this->property, spl_object_hash($this));
            $qb->setParameter($parameter, $this->value);

            $parameterVar = ':'.$parameter;
        } else {
            $parameterVar = sprintf('%s.%s', $dqlAlias, $this->value);
        }

        return $this->getExpression($qb, sprintf('%s.%s', $dqlAlias, $this->property), $parameterVar);
    }

    /**
     * Modifies the query once it has been generated.
     *
     * @param \Doctrine\ORM\Query $query
     */
    public function modifyQuery(Query $query)
    {
    }

    /**
     * Supports a given class name.
     *
     * @param string $className
     * @return bool
     */
    public function supports($className)
    {
        return true;
    }
}
