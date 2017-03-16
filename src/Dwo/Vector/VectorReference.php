<?php

namespace Dwo\Vector;

class VectorReference
{
    /**
     * @var Vector
     */
    public $vector;

    /**
     * @param Vector $vector
     */
    public function __construct(Vector $vector)
    {
        $this->vector = $vector;
    }
}