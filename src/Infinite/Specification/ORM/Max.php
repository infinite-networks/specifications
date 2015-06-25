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

class Max extends AbstractWrap
{
    private $field;

    /**
     * @param string $field
     * @param Specification $specification
     */
    public function __construct($field, Specification $specification = null)
    {
        $this->field = $field;

        parent::__construct($specification);
    }

    public function match(QueryBuilder $qb, $dqlAlias)
    {
        $qb->select(sprintf('MAX(%s.%s)', $dqlAlias, $this->field));

        return parent::match($qb, $dqlAlias);
    }
}
