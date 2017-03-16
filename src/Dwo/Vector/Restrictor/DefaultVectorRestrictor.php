<?php

namespace Dwo\Vector\Restrictor;

class DefaultVectorRestrictor extends AbstractVectorRestrictor implements VectorRestrictorInterface
{
    /**
     * @return array
     */
    public function getAllSizes()
    {
        $all = [];

        foreach ($this->sizes as $fe) {
            $all[$fe[0].'x'.$fe[1]] = [$fe[0], $fe[1]];
            $all[$fe[1].'x'.$fe[0]] = [$fe[1], $fe[0]];
        }

        return array_values($all);
    }

    /**
     * @param int $x
     *
     * @return array
     */
    public function getOpposites($x)
    {
        $return = [];
        foreach ($this->sizes as $size) {
            if ($x === $size[0]) {
                $return[] = $size[1];
            } elseif ($x === $size[1]) {
                $return[] = $size[0];
            }
        }

        return array_values(array_unique($return));
    }
}