<?php

namespace Dwo\Vector\Restrictor;

abstract class AbstractVectorRestrictor
{
    /**
     * @var array
     */
    public $sizes = array();
    /**
     * @var int
     */
    public $maxSite = 1;

    /**
     * @param mixed $maxVectorSize as array: [[1,2],[2,2] or as string: "1x2, 2x2"
     */
    public function __construct($maxVectorSize = array())
    {
        if (is_string($maxVectorSize)) {
            $maxVectorSize = $this->parseRestrictionString($maxVectorSize);
        }
        if (!is_array($maxVectorSize)) {
            throw new \RuntimeException('unsupported type');
        }

        $this->sizes = $maxVectorSize;

        $this->order($this->sizes, $this->maxSite);
    }

    /**
     * @param array $vectorSizes
     * @param null  $maxSite
     */
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
     * @param $string 1x1    1x2    1x3    1x4    1x6    1x8    1x10
     *
     * @return array
     */
    protected function parseRestrictionString($string)
    {
        $maxVectorSize = [];

        foreach (preg_split("/[\s,]+/", $string) as $fe) {
            $maxVectorSize[] = explode('x', $fe);
        }

        return $maxVectorSize;
    }
}