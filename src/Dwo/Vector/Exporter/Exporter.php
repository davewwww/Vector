<?php

namespace Dwo\Vector\Exporter;

use Dwo\Vector\Matrix;

class Exporter
{
    public static function exportByVectorDimension(Matrix $matrix)
    {
        $vectors = [];
        foreach ($matrix->getVectors() as $vector) {
            list($min, $max) = $vector->getDimension();

            $key1 = $min.'x'.$max;
            $key2 = $vector->getValue();

            if (!isset($vectors[$key1])) {
                $vectors[$key1] = [];
            }
            if (!isset($vectors[$key1][$key2])) {
                $vectors[$key1][$key2] = 0;
            }

            $vectors[$key1][$key2]++;
        }

        return $vectors;
    }

    /**
     * @param Matrix $matrix
     *
     * @return array
     */
    public static function exportByVectorValue(Matrix $matrix)
    {
        $vectors = [];
        foreach ($matrix->getVectors() as $vector) {
            list($min, $max) = $vector->getDimension();

            $key1 = $vector->getValue();
            $key2 = $min.'x'.$max;

            if (!isset($vectors[$key1])) {
                $vectors[$key1] = [];
            }
            if (!isset($vectors[$key1][$key2])) {
                $vectors[$key1][$key2] = 0;
            }
            $vectors[$key1][$key2]++;
        }

        return $vectors;
    }
}