<?php

namespace Dwo\Vector\Finder;

use Dwo\Vector\Matrix;
use Dwo\Vector\Position;
use Dwo\Vector\Restrictor\VectorRestrictorInterface;
use Dwo\Vector\Value;
use Dwo\Vector\Vector;

/**
 * Class VectorFinderV2
 */
class VectorFinderV2
{
    /**
     * @param Matrix                    $matrix
     * @param VectorRestrictorInterface $restrictor
     *
     * @return Vector[]
     */
    public function findPossibleVectors(Matrix $matrix, VectorRestrictorInterface $restrictor)
    {
        $possibleVectors = [];

        $sizes = $restrictor->getAllSizes();

        $matrix->map(
            function ($thisValue, Position $position) use ($matrix, $sizes, &$possibleVectors) {
                if (!Value::isValue($thisValue)) {
                    return;
                }

                foreach ($sizes as $size) {
                    $vector = new Vector($position, $size[1], $size[0], $thisValue);

                    if ($matrix->matchVector($vector)) {
                        $possibleVectors[] = $vector;
                    }
                }
            }
        );

        return $possibleVectors;
    }
}