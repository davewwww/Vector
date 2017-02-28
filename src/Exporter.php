<?php

class Exporter
{
    public static function exportByVectorDimension(Matrix $matrix)
    {
        $vectors = [];
        foreach ($matrix->getVectors() as $vector) {
            list($x, $y) = $vector->pos;
            list($min, $max) = $vector->getDimension();

            if (!isset($vectors[$key1 = $min.'x'.$max])) {
                $vectors[$key1] = [];
            }
            if (!isset($vectors[$key1][$key2 = $vector->value])) {
                $vectors[$key1][$key2] = 0;
            }

            #$vectors[$key1][$key2][] = $x.'x'.$y.' ('.$vector->id.')';
            $vectors[$key1][$key2]++;
        }

        return $vectors;
    }

    public static function exportByVectorValue(Matrix $matrix)
    {
        $vectors = [];
        foreach ($matrix->getVectors() as $vector) {
            list($x, $y) = $vector->pos;
            list($min, $max) = $vector->getDimension();

            if (!isset($vectors[$key1 = $vector->value])) {
                $vectors[$key1] = [];
            }
            if (!isset($vectors[$key1][$key2 = $min.'x'.$max])) {
                $vectors[$key1][$key2] = 0;
            }
            $vectors[$key1][$key2]++;
        }

        return $vectors;
    }
}