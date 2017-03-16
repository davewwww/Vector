<?php

namespace Dwo\Vector\Replacer;

use Dwo\Vector\Matrix;
use Dwo\Vector\Restrictor\VectorRestrictorInterface;
use Dwo\Vector\Vector;

interface VectorReplacerInterface
{
    /**
     * @param Matrix                    $matrix
     * @param Vector[]                  $vectors
     * @param VectorRestrictorInterface $restrictor
     */
    public function replaceVectors(Matrix $matrix, array $vectors, VectorRestrictorInterface $restrictor);
}