<?php

class Matrix
{
    public $elements;
    public $height;
    public $width;

    public function __construct($elements)
    {
        $this->elements = $elements;
        $this->height = count($elements);
        $this->width = $this->height > 0 ? count($elements[0]) : 0;
    }

    function orderVectorSizes(array &$vectorSizes)
    {
        foreach ($vectorSizes as $k => $size) {
            $min = min($size[0], $size[1]);
            $max = max($size[0], $size[1]);

            $vectorSizes[$k] = [$min, $max];
        }
    }

    function matchVectorSize(array $dimension, array $vectorSizes)
    {
        $maxIndex = 0;
        $ok = [];

        list($height, $weight) = $dimension;
        $xV = min($height, $weight);
        $yV = max($height, $weight);

        foreach ($vectorSizes as $size) {
            list($xM, $yM) = $size;

            if ($xM <= $xV && $yM <= $yV) {
                $index = $size[0] * $size[1];

                if ($index <= $maxIndex) {
                    continue;
                }

                $maxIndex = $index;
                if (!isset($ok[$index])) {
                    $ok[$index] = [];
                }
                $ok[$index][] = $size;
            }
        }

        return current($ok[$maxIndex]);
    }

    function setMaxVectorSize(&$height, &$width, array $maxVectorSize)
    {
        $format = $height > $width ? 'v' : 'h';

        $minHeight = min($height, $width);
        $maxWeight = max($height, $width);

        $newSize = $this->matchVectorSize([$minHeight, $maxWeight], $maxVectorSize);

        if ('v' === $format) {
            $width = $newSize[0];
            $height = $newSize[1];
        } else {
            $width = $newSize[1];
            $height = $newSize[0];
        }
    }

    function createVectorsWithSameValue(array $maxVectorSize = array())
    {
        if ($maxVectorSize) {
            $this->orderVectorSizes($maxVectorSize);
        }

        $this->map(
            function ($thisValue, $x, $y) use ($maxVectorSize) {
                if ($thisValue instanceof Vector || $thisValue instanceof VectorRef) {
                    return;
                }

                //length
                $height = $this->getHeightWithSameValue($x, $y);
                $width = $this->getWeightForSameValue($x, $y, $thisValue, $height);
                if ($maxVectorSize) {
                    $this->setMaxVectorSize($height, $width, $maxVectorSize);
                }

                //set Vector
                $this->replaceVector(new Vector([$x, $y], $height, $width, $thisValue));
            }
        );
    }

    /**
     * @return Vector[]
     */
    function getVectors()
    {
        $vectors = [];
        $this->map(
            function ($value) use (&$vectors) {
                if ($value instanceof Vector) {
                    $vectors[] = $value;
                }
            }
        );

        return $vectors;
    }

    function getHeightWithSameValue($x, $y)
    {
        $thisValue = $this->get($x, $y);

        $height = 1;

        while (true) {
            $yNext = ($y + $height);
            if ($yNext >= $this->height) {
                break;
            }

            $yNextValue = $this->get($x, $yNext);
            if ($yNextValue instanceof Vector || $yNextValue instanceof VectorRef) {
                break;
            }
            if ($thisValue !== $yNextValue) {
                break;
            }
            $height++;
        }

        return $height;
    }

    function getWeightForSameValue($x, $y, $thisValue, $height = 1)
    {
        $width = 1;

        $xNext = $x;
        while (true) {
            $xNext++;
            if ($xNext >= $this->width) {
                break;
            }

            $valueNext = $this->get($xNext, $y);
            if ($thisValue !== $valueNext) {
                break;
            }

            $heightLeft = $this->getHeightWithSameValue($xNext, $y);
            if ($height > $heightLeft) {
                break;
            }

            $width++;
        }

        return $width;
    }

    public function replaceVector(Vector $vector)
    {
        list($x, $y) = $vector->pos;

        $this->set($x, $y, $vector);

        $vectorRef = new VectorRef($vector);

        $this->mapSub(
            $x,
            $y,
            $vector->width,
            $vector->height,
            function ($v, $x, $y, Matrix $matrix) use ($vectorRef) {
                if (!$matrix->get($x, $y) instanceof Vector) {
                    $matrix->set($x, $y, $vectorRef);
                }
            }
        );
    }

    public function get($x, $y)
    {
        return $this->elements[$y][$x];
    }

    public function set($x, $y, $v)
    {
        return $this->elements[$y][$x] = $v;
    }

    public function map(callable $callback): self
    {
        return $this->mapSub(0, 0, $this->width, $this->height, $callback);
    }

    public function mapSub($x, $y, $rows, $columns, callable $callback = null): self
    {
        $literal = [];

        for ($yy = $y; $yy < $y + $columns; $yy++) {
            $row = [];
            for ($xx = $x; $xx < $x + $rows; $xx++) {
                $value = $this->get($xx, $yy);
                $row[] = $callback ? $callback($value, $xx, $yy, $this) : $value;

            }
            $literal[] = $row;
        }

        return new static($literal);
    }

    public function __toString()
    {
        return trim(
            array_reduce(
                array_map(
                    function ($x) {
                        return '['.implode(', ', $x).']';
                    },
                    $this->elements
                ),
                function ($A, $x) {
                    return $A.\PHP_EOL.$x;
                }
            )
        );
    }
}