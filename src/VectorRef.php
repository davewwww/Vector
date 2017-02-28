<?php

class VectorRef
{
    /**
     * @var Vector
     */
    public $vector;

    public function __construct(Vector $vector)
    {
        $this->vector = $vector;
    }

    public function __toString()
    {
        return ' '. $this->vector->id .' ';

        list($x, $y) = $this->vector->pos;

        return '     '. $x.'x'.$y;
    }
}