<?php

namespace Dwo\Vector;

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

    /**
     * @param int|Position $x
     * @param int|null     $y
     *
     * @return null
     */
    public function get($x, $y = null)
    {
        if ($x instanceof Position) {
            list($x, $y) = $x->get();
        } elseif (is_array($x) && null === $y) {
            list($x, $y) = $x;
        }

        return isset($this->elements[$y]) && isset($this->elements[$y][$x]) ? $this->elements[$y][$x] : null;
    }

    /**
     * @param int $x
     *
     * @return bool
     */
    public function hasRight($x)
    {
        return isset($this->elements[0][$x + 1]);
    }

    /**
     * @param Position $pos
     * @param mixed    $value
     *
     * @return mixed
     */
    public function set(Position $pos, $value)
    {
        return $this->elements[$pos->y][$pos->x] = $value;
    }

    /**
     * @param callable $callback
     *
     * @return Matrix
     */
    public function map(callable $callback)
    {
        return $this->mapSub(new Position(0, 0), $this->width, $this->height, $callback);
    }

    /**
     * @param Position      $position
     * @param int           $rows
     * @param int           $columns
     * @param callable|null $callback
     *
     * @return Matrix
     */
    public function mapSub(Position $position, $rows, $columns, callable $callback = null)
    {
        $elements = [];

        for ($y = $position->y; $y < min($position->y + $columns, $this->height); $y++) {
            $row = [];
            for ($x = $position->x; $x < min($position->x + $rows, $this->width); $x++) {
                $value = $this->get($positionFe = new Position($x, $y));
                $row[] = null !== $callback ? $callback($value, $positionFe, $this) : $value;
            }
            $elements[] = $row;
        }

        return new self($elements);
    }

    /**
     * @param Vector $vector
     *
     * @return bool
     */
    public function matchVector(Vector $vector)
    {
        $position = $vector->position;

        $sizeMatches = ($position->y + $vector->height <= $this->height)
            && ($position->x + $vector->width <= $this->width);

        if ($sizeMatches) {
            $thisValue = $this->get($vector->position);

            $usable = true;
            $this->mapSub(
                $vector->position,
                $vector->width,
                $vector->height,
                function ($value) use ($thisValue, &$usable) {
                    if (!Value::isValue($value) || $value !== $thisValue) {
                        $usable = false;
                    }
                }
            );

            return $usable;
        }

        return false;
    }

    /**
     * @return Vector[]
     */
    public function getVectors()
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

    /**
     * @param Vector $vector
     */
    public function setVector(Vector $vector)
    {
        $this->set($vector->position, $vector);

        $vectorRef = new VectorReference($vector);

        $this->mapSub(
            $vector->position,
            $vector->width,
            $vector->height,
            function ($value, Position $pos) use ($vectorRef) {
                if (!$value instanceof Vector) {
                    $this->set($pos, $vectorRef);
                }
            }
        );
    }
}