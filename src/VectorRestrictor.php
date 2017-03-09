<?php

class VectorRestrictor
{
    public $sizes = array();
    public $maxSite = 1;

    public function __construct(array $maxVectorSize)
    {
        $this->sizes = $maxVectorSize;

        $this->order($this->sizes, $this->maxSite);
    }

    public function getAllSizes() {
        $all = [];

        foreach($this->sizes as $fe) {
            $all[$fe[0].'x'.$fe[1]] = [$fe[0],$fe[1]];
            $all[$fe[1].'x'.$fe[0]] = [$fe[1],$fe[0]];
        }

        return array_values($all);
    }

    private function order(array &$vectorSizes, &$maxSite = null)
    {
        foreach ($vectorSizes as $k => $size) {
            $min = min((int) $size[0], (int) $size[1]);
            $max = max((int) $size[0], (int) $size[1]);

            $vectorSizes[$k] = [$min, $max];

            if ($max > $maxSite) {
                $maxSite = $max;
            }
        }
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

    /**
     * @param $string 1x1    1x2    1x3    1x4    1x6    1x8    1x10
     *
     * @return VectorRestrictor
     */
    public static function createFromString($string)
    {
        $maxVectorSize = [];

        foreach (preg_split("/[\s,]+/", $string) as $fe) {
            $maxVectorSize[] = explode('x', $fe);
        }

        return new self($maxVectorSize);
    }
}