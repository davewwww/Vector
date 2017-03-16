<?php

namespace Dwo\Vector;

class Vector
{
    /**
     * @var Position
     */
    public $position;
    public $height;
    public $width;
    private $value;
    private $id;

    public function __construct(Position $pos, $height, $width, $value)
    {
        $this->position = $pos;
        $this->height = $height;
        $this->width = $width;
        $this->value = $value;
        $this->id = substr(md5(uniqid(time(), true)), 0, 4);
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return array
     */
    public function getWidthAndHeight()
    {
        return [$this->height, $this->width];
    }

    /**
     * sorted WidthAndHight
     *
     * @return array
     */
    public function getDimension()
    {
        $min = min($wh = $this->getWidthAndHeight());
        $max = max($wh);

        return [$min, $max];
    }

    public function __toString()
    {
        return $this->height.'x'.$this->width.'->'. (string) $this->position;
    }
}