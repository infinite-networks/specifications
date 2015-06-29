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

class Size extends Comparison
{
    private $op;

    public function __construct($property, $op, $value)
    {
        parent::__construct($property, $value, true);

        $this->op = $op;
    }

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
        $func = $this->op;

        return $qb->expr()->$func(sprintf('SIZE(%s)', $x), $y);
    }
}
