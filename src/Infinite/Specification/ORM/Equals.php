<?php

/**
 * This file is part of the Infinite Specification library.
 *
 * (c) Infinite Networks Pty Ltd <http://www.infinite.net.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Infinite\Specification\ORM;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

class Equals implements Specification
{
    /**
     * @var string
     */
    private $property;

    /**
     * @var mixed
     */
    private $value;

    public function __construct($property, $value)
    {
        $this->property = $property;
        $this->value = $value;
    }

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
        $parameter = sprintf('%s_%s', $dqlAlias, $this->property);
        $qb->setParameter($parameter, $this->value);

        return $qb->expr()->eq(sprintf('%s.%s', $dqlAlias, $this->property), ':'.$parameter);
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
