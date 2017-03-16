<?php

namespace Dwo\Vector\Finder;

use Dwo\Vector\Matrix;
use Dwo\Vector\Vector;
use VectorRestrictor;

/**
 * Interface VectorFinderInterface
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
interface VectorFinderInterface
{
    /**
     * @param Matrix           $matrix
     * @param VectorRestrictor $restrictor
     *
     * @return Vector[]
     */
    public function findPossibleVectors(Matrix $matrix, VectorRestrictor $restrictor);
}