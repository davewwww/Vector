<?php

class Vector
{
    public $height;
    public $width;
    public $pos;
    public $value;
    public $id;

    public function __construct(array $pos, $height, $width, $value)
    {
        $this->pos = $pos;
        $this->height = $height;
        $this->width = $width;
        $this->value = $value;
        $this->id = substr(md5(uniqid(time(), true)), 0, 4);

    }

    /**
     * @return array
     */
    public function getDimension()
    {
        $min = min($this->height, $this->width);
        $max = max($this->height, $this->width);

        return [$min, $max];
    }

    public function __toString()
    {
        return '['.$this->id.']';

        list($x, $y) = $this->pos;

        return $this->height.'x'.$this->width.'->'.$x.'x'.$y;
    }
}