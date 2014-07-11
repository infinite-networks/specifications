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

class Limit extends AbstractWrap
{
    /**
     * @var int
     */
    private $maxResults;

    /**
     * @var int
     */
    private $firstResult;

    /**
     * @param integer $maxResults
     * @param integer $firstResult
     * @param Specification $specification
     */
    public function __construct($maxResults, $firstResult = 0, Specification $specification = null)
    {
        $this->maxResults = $maxResults;
        $this->firstResult = $firstResult;

        parent::__construct($specification);
    }

    public function modifyQuery(Query $query)
    {
        parent::modifyQuery($query);

        $query->setMaxResults($this->maxResults);
        $query->setFirstResult($this->firstResult);
    }
}
