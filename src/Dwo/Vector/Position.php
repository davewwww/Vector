<?php

namespace Dwo\Vector;

class Position
{
    /**
     * @var int
     */
    public $x;
    /**
     * @var int
     */
    public $y;

    /**
     * @param int $x
     * @param int $y
     */
    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @return array
     */
    public function get()
    {
        return [$this->x, $this->y];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return implode('x', $this->get());
    }
}