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

class SingleScalar extends AbstractWrap
{
    public function modifyQuery(Query $query)
    {
        parent::modifyQuery($query);

        $query->setHydrationMode($query::HYDRATE_SINGLE_SCALAR);
    }
}
