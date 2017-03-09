<?php

class VectorReplacer
{

    /**
     * @param Matrix   $matrix
     * @param Vector[] $vectors
     */
    public static function replaceVectors(Matrix $matrix, array $vectors)
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
            list($x, $y) = $vector->pos;
            $thisValue = $vector->getValue();

            $usable = true;
            $matrix->mapSub(
                $x,
                $y,
                $vector->width,
                $vector->height,
                function ($value, $xx, $yy, Matrix $matrix) use ($thisValue, &$usable) {
                    if (!$matrix->isValue($value) || $value !== $thisValue) {
                        $usable = false;
                    }
                }
            );

            if ($usable) {
                $matrix->replaceVector($vector);
            }
        }
    }
}