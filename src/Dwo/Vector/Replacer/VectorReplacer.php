<?php

namespace Dwo\Vector\Replacer;

use Dwo\Vector\Matrix;
use Dwo\Vector\Restrictor\LimitedVectorRestrictorInterface;
use Dwo\Vector\Restrictor\VectorRestrictorInterface;
use Dwo\Vector\Vector;

class VectorReplacer implements VectorReplacerInterface
{
    /**
     * @param Matrix                           $matrix
     * @param Vector[]                         $vectors
     * @param LimitedVectorRestrictorInterface $restrictor
     */
    public function replaceVectors(Matrix $matrix, array $vectors, VectorRestrictorInterface $restrictor)
    {
        //order
        $orderByQ = $orderByH = [];
        foreach ($vectors as $vector) {
            $dim = $vector->getWidthAndHeight();
            $orderByQ[] = $dim[0] * $dim[1];
            $orderByH[] = $dim[0] > $dim[1];
        }
        array_multisort($orderByQ, SORT_DESC, $orderByH, SORT_DESC, $vectors);

        //replace
        foreach ($vectors as $vector) {
            if(!$restrictor->isUsable($vector)) {
                continue;
            }

            if ($matrix->matchVector($vector)) {
                $matrix->setVector($vector);

                $restrictor->used($vector);
            }
        }
    }
}