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
 * Base functions for composite specifications.
 */
abstract class AbstractComposite implements Specification
{
    const METHOD = '';

    /**
     * @var Specification[]
     */
    private $children;

    public function __construct()
    {
        if (func_num_args() === 1) {
            $this->children = func_get_arg(0);
        } else {
            $this->children = func_get_args();
        }
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
        $exprs = array_map(function (Specification $specification) use ($qb, $dqlAlias) {
            return $specification->match($qb, $dqlAlias);
        }, $this->children);
        $exprs = array_filter($exprs);

        if (!$exprs) {
            return null;
        }

        return call_user_func_array(
            array($qb->expr(), static::METHOD),
            $exprs
        );
    }

    /**
     * Modifies the query once it has been generated.
     *
     * @param \Doctrine\ORM\Query $query
     */
    public function modifyQuery(Query $query)
    {
        foreach ($this->children as $child) {
            $child->modifyQuery($query);
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
        foreach ($this->children as $child) {
            if (!$child->supports($className)) {
                return false;
            }
        }

        return true;
    }
}
