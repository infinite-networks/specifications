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

use Doctrine\ORM\EntityRepository as BaseEntityRepository;

class EntityRepository extends BaseEntityRepository
{
    /**
     * Returns objects matching a specification.
     *
     * @param Specification $specification
     * @return array
     * @throws \InvalidArgumentException
     */
    public function match(Specification $specification)
    {
        return $this->getQuery($specification)->execute();
    }

    /**
     * Returns a single object matchinging a specification.
     *
     * @param Specification $specification
     * @return mixed
     */
    public function matchOne(Specification $specification)
    {
        return $this->getQuery($specification)->getSingleResult();
    }

    /**
     * Transforms a Specification into a Query
     *
     * @param Specification $specification
     * @return \Doctrine\ORM\Query
     * @throws \InvalidArgumentException
     */
    private function getQuery(Specification $specification)
    {
        if (!$specification->supports($this->getEntityName())) {
            throw new \InvalidArgumentException("Specification does not support this repository");
        }

        $qb = $this->createQueryBuilder('e');
        if ($expr = $specification->match($qb, 'e')) {
            $qb->where($expr);
        }
        $query = $qb->getQuery();
        $specification->modifyQuery($query);

        return $query;
    }
}
