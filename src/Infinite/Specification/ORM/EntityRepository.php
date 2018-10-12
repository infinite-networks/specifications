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
use Doctrine\ORM\Tools\Pagination\Paginator;

class EntityRepository extends BaseEntityRepository
{
    /**
     * Returns an IterableResult for the specification.
     *
     * @param Specification $specification
     * @return array
     */
    public function iterate(Specification $specification)
    {
        return $this->getQuery($specification)->iterate();
    }
    
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
     * Returns paginated objects matching a specification.
     *
     * @param Specification $specification
     *
     * @return Paginator
     */
    public function matchPaginated(Specification $specification)
    {
        return new Paginator($this->getQuery($specification));
    }

    /**
     * Returns a single object matching a specification.
     *
     * @param Specification $specification
     * @return mixed
     */
    public function matchOne(Specification $specification)
    {
        return $this->getQuery($specification)->getSingleResult();
    }

    /**
     * Returns a single object matching a specification or null if no matches are found.
     *
     * @param Specification $specification
     * @return mixed
     */
    public function matchOneOrNull(Specification $specification)
    {
        return $this->getQuery($specification)->getOneOrNullResult();
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
