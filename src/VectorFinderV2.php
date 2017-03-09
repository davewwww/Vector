<?php

class VectorFinderV2
{
    /**
     * @param Matrix           $matrix
     * @param VectorRestrictor $restrictor
     *
     * @return Vector[]
     */
    public static function findPossibleVectors(Matrix $matrix, VectorRestrictor $restrictor)
    {
        $possibleVectors = [];

        $sizes = $restrictor->getAllSizes();

        $matrix->map(
            function ($thisValue, $x, $y) use ($matrix, $sizes, &$possibleVectors) {
                if (!$matrix->isValue($thisValue)) {
                    return;
                }

                foreach ($sizes as $size) {
                    $usable = true;
                    $matrix->mapSub(
                        $x,
                        $y,
                        $size[0],
                        $size[1],
                        function ($value) use ($matrix, $thisValue, &$usable) {
                            if (!$matrix->isValue($value) || $value !== $thisValue) {
                                $usable = false;
                            }
                        }
                    );

                    if ($usable) {
                        $possibleVectors[] = new Vector([$x, $y], $size[1], $size[0], $thisValue);
                    }
                }
            }
        );

        return $possibleVectors;
    }
}