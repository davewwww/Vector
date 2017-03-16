<?php

namespace Dwo\Vector\Restrictor;

use Dwo\Vector\Vector;

interface VectorRestrictorInterface
{
    /**
     * @return array
     */
    public function getAllSizes();

    /**
     * @param int $x
     *
     * @return array
     */
    public function getOpposites($x);

}