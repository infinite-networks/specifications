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

class LessThan extends Comparison
{
    /**
     * Should return an expression to be used for the comparison.
     *
     * @param QueryBuilder $qb
     * @param string $x
     * @param string $y
     * @return Query\Expr
     */
    protected function getExpression(QueryBuilder $qb, $x, $y)
    {
        return $qb->expr()->lt($x, $y);
    }
}
