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

abstract class AbstractWrap implements Specification
{
    /**
     * @var Specification
     */
    protected $specification;

    /**
     * @param Specification $specification
     */
    public function __construct(Specification $specification = null)
    {
        $this->specification = $specification;
    }

    /**
     * Adds conditions to the query builder related to the specification. The
     * specification should add parameters as required and return the expression to be
     * added to the QueryBuilder.
     *
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @param string $dqlAlias
     * @return \Doctrine\ORM\Query\Expr
     */
    public function match(QueryBuilder $qb, $dqlAlias)
    {
        return $this->specification ?
            $this->specification->match($qb, $dqlAlias) :
            null;
    }

    /**
     * Modifies the query once it has been generated.
     *
     * @param \Doctrine\ORM\Query $query
     */
    public function modifyQuery(Query $query)
    {
        if ($this->specification) {
            $this->specification->modifyQuery($query);
        }
    }

    /**
     * Supports a given class name.
     *
     * @param string $className
     * @return bool
     */
    public function supports($className)
    {
        if ($this->specification) {
            return $this->specification->supports($className);
        }

        return true;
    }
}
