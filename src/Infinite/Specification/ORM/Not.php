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

/**
 * Negates a specification.
 */
class Not extends AbstractWrap
{
    public function __construct(Specification $specification)
    {
        parent::__construct($specification);
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
        return $qb->expr()->not($this->specification->match($qb, $dqlAlias));
    }
}
